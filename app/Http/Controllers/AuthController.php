<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            $credentials = $request->only('nama', 'password');

            if (!Auth::attempt($credentials, $request->boolean('remember'))) {
                return back()
                    ->withErrors(['nama' => 'Nama atau kata sandi salah.'])
                    ->onlyInput('nama');
            }

            $request->session()->regenerate();

            $roleId = Auth::user()->role_id;

            return match ($roleId) {
                default => redirect()->intended(route('dashboard'))
                    ->with('success', 'Selamat datang, ' . Auth::user()->nama . '!'),
            };
        } catch (\Exception $e) {
            return back()
                ->withErrors(['nama' => 'Terjadi kesalahan saat login. Silakan coba lagi.'])
                ->onlyInput('nama');
        }
    }

    public function logout(Request $request)
    {
        $nama = Auth::user()->nama;

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('info', 'Sampai jumpa, ' . $nama . '!');
    }
}
