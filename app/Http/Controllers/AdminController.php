<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Produk;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalProduk = Produk::count();
        $totalPelanggan = User::where('status', 'pelanggan')->count();
        $totalPesanan = Pemesanan::count();
        $totalPendapatan = Pemesanan::where('status', 'setuju')
            ->where('metode_pembayaran', 'Lunas')
            ->sum('total_harga');

        $totalSetuju = Pemesanan::where('status', 'setuju')->count();
        $totalPending = Pemesanan::where('status', 'pending')->count();

        $penjualanBulanan = Pemesanan::where('status', 'setuju')
            ->where('metode_pembayaran', 'Lunas')
            ->get()
            ->groupBy(function ($item) {
                return $item->created_at->translatedFormat('F'); // Nama bulan dalam bahasa Indonesia
            })
            ->map(function ($group) {
                return $group->sum('total_harga');
            });



        return view('dashboard.halamanadmin', compact(
            'totalProduk',
            'totalPelanggan',
            'totalPesanan',
            'totalPendapatan',
            'totalSetuju',
            'totalPending',
            'penjualanBulanan'
        ));
    }
}
