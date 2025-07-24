<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class PemesananController extends Controller
{
    public function simpan(Request $request, $id_produk)
    {
        $request->validate([
            'tanggal_ambil' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'total_harga' => 'required|integer',
            'metode_pembayaran' => 'required|in:DP,Lunas',
            'jenis_pembayaran' => 'required|in:Transfer,Tunai',
            'nominal_dp' => 'nullable|integer',
            'bukti_transfer' => 'nullable|file|image|mimes:jpg,jpeg,png|max:2048',
            'alamat' => 'required|string|max:255',
        ]);

        // Update alamat user jika diedit
        $user = Auth::user();
        $user->alamat = $request->alamat;
        $user->save();

        // Upload bukti
        $buktiTransferPath = null;
        if ($request->hasFile('bukti_transfer')) {
            $file = $request->file('bukti_transfer');

            // 1. Simpan ke storage (path untuk database)
            $buktiTransferPath = $file->store('bukti_transfer', 'public');

            // 2. Simpan ke public folder juga
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('bukti_transfer'), $namaFile);
            $buktiTransferPath = 'bukti_transfer/' . $namaFile;
        }

        // Simpan pemesanan
        $pemesanan = Pemesanan::create([
            'user_id' => $user->id_user,
            'produk_id' => $id_produk,
            'tanggal_ambil' => $request->tanggal_ambil,
            'jumlah' => $request->jumlah,
            'total_harga' => $request->total_harga,
            'metode_pembayaran' => $request->metode_pembayaran,
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'nominal_dp' => $request->metode_pembayaran === 'DP' ? $request->nominal_dp : null,
            'sisa_pembayaran' => $request->metode_pembayaran === 'DP'
                ? $request->total_harga - $request->nominal_dp
                : null,
            'bukti_transfer' => $buktiTransferPath,
            'status' => 'pending',
        ]);

        // Buat isi pesan
        $pesan = "*Pesanan Baru!*\n"
            . "Nama: {$user->namalengkap}\n"
            . "No HP: {$user->nomortelepon}\n"
            . "Alamat: {$user->alamat}\n"
            . "Tanggal Ambil: {$request->tanggal_ambil}\n"
            . "Jumlah: {$request->jumlah}\n"
            . "Total: Rp " . number_format($request->total_harga, 0, ',', '.') . "\n"
            . "Metode: {$request->metode_pembayaran} ({$request->jenis_pembayaran})";

        if ($request->metode_pembayaran === 'DP') {
            $sisa = $request->total_harga - $request->nominal_dp;
            $pesan .= "\nNominal DP: Rp " . number_format($request->nominal_dp, 0, ',', '.');
            $pesan .= "\nSisa Bayar: Rp " . number_format($sisa, 0, ',', '.');
        }

        // Kirim WA ke semua admin
        $admins = User::where('status', 'admin')->get();
        foreach ($admins as $admin) {
            Http::withHeaders([
                'Authorization' => '9fd5BVdFtu6m4tYmHYMQ',
            ])->withoutVerifying()->post('https://api.fonnte.com/send', [
                'target' => $admin->nomortelepon,
                'message' => $pesan,
                'countryCode' => '62',
            ]);
        }

        return redirect()->route('pelanggan.riwayat')->with('success', 'Pesanan berhasil dikirim!');
    }

    public function riwayat()
    {
        $orders = Pemesanan::where('user_id', Auth::id())->latest()->get();
        return view('pelanggan.riwayatpemesanan', compact('orders'));
    }

    public function pelunasan(Request $request, $id)
    {
        $request->validate([
            'bukti_pelunasan' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $pemesanan = Pemesanan::findOrFail($id);

        if ($pemesanan->sisa_pembayaran <= 0) {
            return back()->with('error', 'Pesanan ini sudah lunas.');
        }

        $file = $request->file('bukti_pelunasan');

        // Simpan ke storage (untuk database & backup)
        $storagePath = $file->store('bukti_pelunasan', 'public');

        // Simpan juga ke public folder agar langsung bisa diakses
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('bukti_pelunasan'), $fileName);

        // Update data: gunakan path versi publik
        $pemesanan->update([
            'bukti_pelunasan' => 'bukti_pelunasan/' . $fileName,
            'sisa_pembayaran' => 0,
            'nominal_dp' => 0,
            'metode_pembayaran' => 'Lunas',
        ]);

        return back()->with('success', 'Pelunasan berhasil dikirim.');
    }


    public function batalkan($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        if (in_array($pemesanan->status, ['lunas', 'setuju'])) {
            return back()->with('error', 'Pesanan tidak bisa dibatalkan.');
        }

        $pemesanan->delete();

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
