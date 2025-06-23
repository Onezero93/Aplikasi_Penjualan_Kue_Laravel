<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    //
    public function tampilanPemesan()
    {
        $orders = Pemesanan::with(['user', 'produk'])->latest()->get();

        return view('pelanggan.datapelanggan', compact('orders'));
    }

    public function updateStatusPemesanan(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,setuju',
        ]);

        $order = Pemesanan::findOrFail($id);
        if ($order->status !== 'setuju') {
            $order->status = $request->status;
            $order->save();
        }

        return back()->with('success', 'Status berhasil diperbarui.');
    }

    public function kirimWA($id)
    {
        $order = Pemesanan::with('user', 'produk')->findOrFail($id);

        $nomor = $order->user->nomortelepon;
        $pesan = "Halo *{$order->user->namalengkap}*, 👋\n"
            . "Status Pemesanan Anda: *" . ucfirst($order->status) . "*\n"
            . "Terima kasih telah melakukan pemesanan kue di *Toko Anugerah Roti*.\n\n"
            . "*Rincian Pemesanan Kue Anda*\n"
            . "Atas Nama: {$order->user->namalengkap}\n"
            . "Kue: {$order->produk->nama_produk}\n"
            . "Harga Kue Satuan: Rp " . number_format($order->produk->harga, 0, ',', '.') . "\n"
            . "Tanggal Pesan: " . $order->created_at->format('d-m-Y H:i') . "\n"
            . "Tanggal Ambil: {$order->tanggal_ambil}\n"
            . "Jumlah Kue: {$order->jumlah}\n"
            . "Total Harga: Rp " . number_format($order->total_harga, 0, ',', '.') . "\n"
            . "Metode Pembayaran: {$order->metode_pembayaran} ({$order->jenis_pembayaran})\n";

        if ($order->metode_pembayaran === 'DP') {
            $pesan .= "Nominal DP: Rp " . number_format($order->nominal_dp, 0, ',', '.') . "\n";
            $pesan .= "Sisa Pembayaran: Rp " . number_format($order->sisa_pembayaran, 0, ',', '.') . "\n";
        }

        if ($order->bukti_transfer) {
            $pesan .= "Bukti Transfer: Tersedia\n";
            $pesan .= "📎 Lihat: " . url('storage/' . $order->bukti_transfer);
        }

        Http::withHeaders([
            'Authorization' => '9fd5BVdFtu6m4tYmHYMQ', // Ganti sesuai token kamu
        ])->withoutVerifying()->post('https://api.fonnte.com/send', [
            'target' => $nomor,
            'message' => $pesan,
            // 'image' => url('storage/' . $order->bukti_transfer),
            'countryCode' => '62',
        ]);

        return back()->with('success', 'Pesan WA berhasil dikirim!');
    }
}
