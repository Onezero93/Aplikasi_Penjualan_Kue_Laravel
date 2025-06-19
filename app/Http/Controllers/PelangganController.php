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

}
