<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class RegistrasiController extends Controller
{

    public function showRegisterForm()
{
    return view('auth.registrasi');
}
    // Proses registrasi
    public function registrasi(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'namalengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'nomortelepon' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status'        => 'in:pelanggan',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambar     = $request->file('gambar');
            $gambarName = time() . '_' . $gambar->getClientOriginalName();
            $gambar->move(public_path('fotos'), $gambarName);
            $gambarPath = 'fotos/' . $gambarName;
        }

        User::create([
            'namalengkap'   => $request->namalengkap,
            'username'      => $request->username,
            'password'      => Hash::make($request->password),
            'alamat'        => 'Alamat belum di isi',
            'nomortelepon'  => $request->nomortelepon,
            'gambar'        => $gambarPath,
            'status'        => $request->status,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
    }
}
