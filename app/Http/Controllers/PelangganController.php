<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Keranjang;
use Illuminate\Support\Facades\Auth;
class PelangganController extends Controller
{
    //
    public function tampilProdukPelanggan(Request $request){
        $produk = Produk::all();
        return view('pelanggan.home', compact('produk'));
    }
    public function formPemesanan($id_produk)
{
    $produk = Produk::findOrFail($id_produk);
    return view('pelanggan.form_pemesanan', compact('produk'));
}

public function byKategori($kategori)
{
    $produk = Produk::where('kategori', $kategori)->get();
    return view('pelanggan.kuekami', compact('produk', 'kategori'));
}

public function simpanKeranjang($id_produk)
{
    // Cek apakah produk sudah ada di keranjang user
    $existing = Keranjang::where('user_id', Auth::id())
                         ->where('produk_id', $id_produk)
                         ->first();

    if (!$existing) {
        Keranjang::create([
            'user_id' => Auth::id(),
            'produk_id' => $id_produk,
        ]);
    }

    return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
}

public function tampilanKeranjang()
{
    $items = Keranjang::with('produk')->where('user_id', Auth::id())->get();
    return view('pelanggan.keranjang', compact('items'));
}

public function hapusKeranjang($id_keranjang)
{
    $item = Keranjang::where('id_keranjang', $id_keranjang)
                     ->where('user_id', Auth::id())
                     ->first();

    if ($item) {
        $item->delete();
        return back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    return back()->with('error', 'Item tidak ditemukan atau bukan milik Anda.');
}




}
