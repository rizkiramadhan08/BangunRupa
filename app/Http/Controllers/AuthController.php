<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function formRegister(){
        $title = 'Sign In';
        return view('auth/register',  compact('title'));
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
    }
    public function formLogin(){
        $title = 'Login';

        return view('auth/login', compact('title'));
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors([
            'email' => 'Email tidak terdaftar.',
        ])->withInput();
    }

    if (!is_string($user->password) || !Hash::check($request->password, $user->password)) {
        return back()->withErrors([
            'password' => 'Password salah.',
        ])->withInput();
    }

    if (isset($user->is_active) && !$user->is_active) {
        return back()->withErrors([
            'email' => 'Akun Anda tidak aktif.',
        ]);
    }

    Auth::login($user);

    return $user->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('home');
}

    public function logout() {
        Auth::logout();
        return redirect()->route('home');
    }
}