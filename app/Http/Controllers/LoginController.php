<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    //
    public function showLoginForm()
    {
        return view('auth.login'); // Pastikan ada file resources/views/login.blade.php
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $user = Auth::user();

            if ($user->status === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->status === 'pelanggan') {
                return redirect()->route('pelanggan.produk');
            } else {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Status tidak dikenali.');
            }
        }

        return redirect()->route('login')->with('error', 'Username atau password salah.');
    }

    // Logout
    public function logout()
{
    // Simpan role sebelum logout
    $role = Auth::user()->status ?? null;

    Auth::logout();

    // Cek role: jika pelanggan, arahkan ke halaman utama pelanggan
    if ($role === 'pelanggan') {
        return redirect()->route('pelanggan.produk'); // ke route '/'
    }

    // Default untuk admin dan lainnya
    return redirect()->route('login');
}


}
