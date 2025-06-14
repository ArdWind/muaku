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

        $request['Status'] = "verify";
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
                'Status' => 'active'
            ]);
        }

        if ($user && $user->Status == 'banned') {
            return redirect('/login')->with('failed', 'akun anda telah dibekukan');
        }

        if ($user && $user->Status == 'verify') {
            $user->update(['Status' => 'active']);
        }

        Auth::login($user);

        if ($user->role == 'admin' || $user->role == 'staff') {
            return redirect('/dashboard');
        } elseif ($user->role == 'customer') {
            return redirect('/customer');
        }
        return redirect('/login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate(); // Hapus semua session
        $request->session()->regenerateToken(); // Amankan CSRF

        return redirect('/login');
    }
}
