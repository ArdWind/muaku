<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Mail\OtpEmail;
use App\Models\Verification;
use GuzzleHttp\Promise\Create;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail as FacadesMail;
use Mail;

class VerificationController extends Controller
{
    public function index()
    {
        return view('verification.index');
    }

    public function show($unique_id)
    {
        $verify = Verification::whereUserId(Auth::user()->id)->whereUniqueId($unique_id)
            ->whereStatus('active')->count();
        if (!$verify) abort(404);
        return view('verification.show', compact('unique_id'));
    }

    public function update(Request $request, $unique_id)
    {
        $verify = Verification::whereUserId(Auth::user()->id)
            ->whereUniqueId($unique_id)
            ->whereStatus('active')
            ->first();


        if (empty($verify)) abort(404);

        try {
            DB::beginTransaction();
            // Bandingkan OTP
            if (!Hash::check(trim($request->otp), $verify->otp)) {
                $verify->update(['Status' => 'invalid']);
                return redirect('/verify')->with('error', 'Kode OTP salah');
            }

            // Jika cocok
            // $verify->update(['Status' => 'valid']);
            $verify->delete();
            User::whereId($verify->user_id)->update(['Status' => 'active']);


            DB::commit();
            return redirect('/customer');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $th->getMessage();
        }
    }

    public function store(Request $request)
    {
        if ($request->type == 'register') {
            $user = User::find($request->user()->id);
        } else {
            // $user = reset password
        }
        if (!$user) return back()->with('failed', 'user not found.');
        $otp = rand(100000, 999999);
        $verify = Verification::create([
            'user_id' => $user->id,
            'unique_id' => uniqid(),
            'otp' =>  Hash::make($otp),
            'type' => $request->type,
            'send_via' => 'email'
        ]);
        FacadesMail::to($user->email)->queue(new OtpEmail($otp));
        if ($request->type == 'register') {
            return redirect('/verify/' . $verify->unique_id);
        }
        // return redirect('/reset-password');
    }
}
