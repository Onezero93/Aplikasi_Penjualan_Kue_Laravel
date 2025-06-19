<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //menampilkan data pengguna
    public function tampilData(Request $request)
    {
        $pengguna = User::all();
        return view('pengguna.datapengguna', compact('pengguna'));
    }

    //menambahkan data pengguna
    public function tambahData(Request $request)
    {
        $request->validate([
            'namalengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'nomortelepon' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:admin,pelanggan',


        ]);
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambarName = time() . '_' . $gambar->getClientOriginalName();
            $gambarPath = 'fotos/' . $gambarName;
            $gambar->move(public_path('fotos'), $gambarName);
        }

        User::create([
            'namalengkap' => $request->namalengkap,
            'username' => $request->username,
            'password' => Hash::make($request->password), // Enkripsi password
            'alamat' => $request->alamat,
            'nomortelepon' => $request->nomortelepon,
            'gambar' => $gambarPath,
            'status' => $request->status,

        ]);

        return redirect()->route('pengguna.datapengguna')->with('success', 'Admin berhasil ditambahkan!');
    }


    public function perbaruiData(Request $request, string $id_user)
    {
        $user = User::findOrFail($id_user);
        $request->validate([
            'namalengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|max:255',
            'alamat' => 'required|string|max:255',
            'nomortelepon' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:admin,pelanggan',
        ]);

        $user->namalengkap = $request->namalengkap;
        $user->username = $request->username;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->alamat = $request->alamat;
        $user->nomortelepon = $request->nomortelepon;

        // Cek jika ada gambar baru diunggah
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if (!empty($user->gambar) && file_exists(public_path($user->gambar))) {
                unlink(public_path($user->gambar));
            }

            // Simpan gambar baru
            $gambar = $request->file('gambar');
            $gambarName = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('fotos'), $gambarName);
            $user->gambar = 'fotos/' . $gambarName;
        }

        $user->status = $request->status;

        $user->save();

        return redirect()->route('pengguna.datapengguna')->with('success', 'Pengguna berhasil diperbarui!');
    }

    //hapus Pengguna
    public function hapusData(string $id)
    {
        $user = User::find($id);

        // Hapus file gambar jika ada
        if ($user->gambar && File::exists(public_path($user->gambar))) {
            File::delete(public_path($user->gambar));
        }

        $user->delete();

        return redirect()->route('pengguna.datapengguna')->with('success', 'Pengguna berhasil dihapus!');
    }

    
    // public function perbaruiProfil(Request $request)
    // {
    //     $user = Auth::user();

    //     $request->validate([
    //         'namalengkap' => 'required|string|max:255',
    //         'username' => 'required|string|max:255|unique:user,username,' . $user->id_user . ',id_user',
    //         'password' => 'nullable|string|min:6|max:255',
    //         'alamat' => 'required|string|max:255',
    //         'nomortelepon' => 'required|string|max:255',
    //         'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     $user->namalengkap = $request->namalengkap;
    //     $user->username = $request->username;

    //     if ($request->filled('password')) {
    //         $user->password = Hash::make($request->password);
    //     }

    //     $user->alamat = $request->alamat;
    //     $user->nomortelepon = $request->nomortelepon;

    //     if ($request->hasFile('gambar')) {
    //         if (!empty($user->gambar) && file_exists(public_path($user->gambar))) {
    //             unlink(public_path($user->gambar));
    //         }

    //         $gambar = $request->file('gambar');
    //         $gambarName = time() . '.' . $gambar->getClientOriginalExtension();
    //         $gambar->move(public_path('fotos'), $gambarName);
    //         $user->gambar = 'fotos/' . $gambarName;
    //     }

    //     $user->save();

    //     return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    // }
}
