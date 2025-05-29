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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        // Validasi request
        $request->validate([
            'type' => 'required|in:register,reset_password',
            'send_via' => 'required|in:email,whatsapp'
        ]);

        // Cari user berdasarkan konteks
        if ($request->type == 'register') {
            $user = User::find(Auth::id());
        } else {
            // Untuk reset password (contoh pencarian via email)
            $user = User::where('email', $request->email)->first();
        }

        // Validasi user
        if (!$user) {
            return back()->with('failed', 'User tidak ditemukan');
        }

        // Validasi nomor WhatsApp jika dikirim via WA
        if ($request->send_via == 'whatsapp' && empty($user->Phone)) {
            return back()->with('failed', 'Nomor WhatsApp tidak terdaftar');
        }

        // Generate OTP
        $otp = rand(100000, 999999);

        try {
            DB::beginTransaction();

            // Hapus OTP sebelumnya jika ada
            Verification::where('user_id', $user->id)
                ->where('type', $request->type)
                ->delete();

            // Simpan OTP baru
            $verify = Verification::create([
                'user_id' => $user->id,
                'unique_id' => uniqid(),
                'otp' => Hash::make($otp),
                'type' => $request->type,
                'send_via' => $request->send_via
            ]);

            // Kirim OTP sesuai channel
            switch ($request->send_via) {
                case 'email':
                    Mail::to($user->email)
                        ->queue(new OtpEmail($otp));
                    break;

                case 'whatsapp':
                    $this->sendWhatsAppOtp(
                        $user->Phone,
                        $otp,
                        $request->type
                    );
                    break;
            }

            DB::commit();

            // Redirect untuk verifikasi
            if ($request->type == 'register') {
                return redirect('/verify/' . $verify->unique_id);
            }

            return redirect('/reset-password')->with('success', 'OTP telah dikirim');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('OTP Error: ' . $e->getMessage());
            return back()->with('failed', 'Gagal mengirim OTP');
        }
    }

    private function sendWhatsAppOtp($phoneNumber, $otp, $type)
    {
        // Format nomor (62xxxxxxxxxxx)
        $formattedPhone = preg_replace('/^0/', '62', $phoneNumber);
        $formattedPhone = preg_replace('/[^0-9]/', '', $formattedPhone);

        // Custom message berdasarkan tipe
        $messageType = ($type == 'register') ? 'registrasi akun' : 'reset password';

        $text = "[VERIFIKASI KODE OTP MUA.KU]\n\n"
            . "Kode OTP Anda adalah: {$otp}\n"
            . "Digunakan untuk {$messageType}\n\n"
            // . "⏰ Berlaku 5 menit\n"
            . "JANGAN berikan kode ini ke siapapun!\n\n"
            . "Terima kasih 🙏";

        // Kirim via API Ojan
        $response = Http::post(config('whatsapp.api_url'), [ // <<< Menggunakan config()
            'apikey'   => config('whatsapp.api_key'),        // <<< Menggunakan config()
            'mtype'    => 'text',
            'receiver' => $formattedPhone,
            'text'     => $text,
            'url'      => null,
            'filename' => null,
        ]);

        // Handle error response
        if ($response->failed()) {
            throw new \Exception('Gagal mengirim WhatsApp: ' . $response->body());
        }
    }
}
