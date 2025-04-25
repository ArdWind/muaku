<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:50',
            'password' => 'required|max:50',
        ]);
        if (Auth::attempt($request->only('email', 'password'), $request->remember)) {
            if (Auth::user()->role == 'customer') return redirect('/customer');
            return redirect('/dashboard');
        }
        return back()->with('failed', 'email atau password salah');
    }

    function register(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email|max:50',
            'password' => 'required|max:50|min:8',
            'confirm_password' => 'required|max:50|min:8|same:password',
        ]);

        $request['status'] = "verify";
        $user = User::create($request->all());
        Auth::login($user);
        return redirect('/customer');
    }

    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        $googleUser = Socialite::driver('google')->user();
        $user = User::whereEmail($googleUser->email)->first();
        if (!$user) {
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => bcrypt(Str::random(16)),
                'status' => 'active'
            ]);
        }

        if ($user && $user->status == 'banned') {
            return redirect('/login')->with('failed', 'akun anda telah dibekukan');
        }

        if ($user && $user->status == 'verify') {
            $user->update(['status' => 'active']);
        }

        Auth::login($user);
        if ($user->role == 'customer') return redirect('/customer');
        return Redirect('/customer');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
