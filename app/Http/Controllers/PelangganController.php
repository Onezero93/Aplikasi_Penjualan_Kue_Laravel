<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
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



}
