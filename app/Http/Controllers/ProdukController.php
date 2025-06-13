<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\File;

class ProdukController extends Controller
{
    //
        public function tampilProduk(Request $request){
        $produk = Produk::all();
        return view('produk.dataproduk', compact('produk'));
    }

    public function tambahProduk(Request $request){
    $request->validate([
        'nama_produk' => 'required|string|max:255',
        'harga' => 'required|string|max:255',
        'stok' => 'required|string|max:255',
        'kategori' => 'required|in:basah,kering',
        'foto_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $gambarProduk = null;
    if ($request->hasFile('foto_produk')) {
        $gambar = $request->file('foto_produk');
        $gambarName = time() . '_' . $gambar->getClientOriginalName();
        $gambarProduk = 'fotosproduk/' . $gambarName;

        // Pastikan direktori ada
        if (!file_exists(public_path('fotosproduk'))) {
            mkdir(public_path('fotosproduk'), 0755, true);
        }

        $gambar->move(public_path('fotosproduk'), $gambarName);
    }

    Produk::create([
        'nama_produk' => $request->nama_produk,
        'harga' => $request->harga,
        'stok' => $request->stok,
        'kategori' => $request->kategori,
        'foto_produk' => $gambarProduk,
    ]);

    return redirect()->route('produk.dataproduk')->with('success', 'Admin berhasil ditambahkan!');
}


//     public function detailJasa($id_jasa)
// {
//     $jasa = Jasa::findOrFail($id_jasa);
//     return view('jasa.detailjasa', compact('jasa'));
// }



public function perbaruiProduk(Request $request, $id_produk)
{
    $request->validate([
        'nama_produk' => 'required|string|max:255',
        'harga' => 'required|string|max:255',
        'stok' => 'required|string|max:255',
        'kategori' => 'required|in:basah,kering',
        'foto_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $produk = Produk::findOrFail($id_produk);

    if ($request->hasFile('foto_produk')) {
        // Hapus gambar lama jika ada
        if ($produk->foto_produk && file_exists(public_path($produk->foto_produk))) {
            unlink(public_path($produk->foto_produk));
        }

        // Simpan gambar baru
        $gambar = $request->file('foto_produk');
        $gambarName = time() . '_' . $gambar->getClientOriginalName();
        $gambarProduk = 'fotosproduk/' . $gambarName;
        $gambar->move(public_path('fotosproduk'), $gambarName);
        $produk->foto_produk = $gambarProduk;
    }

    // Perbarui data jasa
    $produk->update([
        'nama_produk' => $request->nama_produk,
        'harga' => $request->harga,
        'stok' => $request->stok,
        'kategori' => $request->kategori,
        // 'foto_produk' => $gambarProduk,
    ]);

    return redirect()->route('produk.dataproduk')->with('success', 'Jasa berhasil diperbarui!');
}

public function hapusProduk(string $id)
{
    $produk = Produk::find($id);

    if (!$produk) {
        return redirect()->route('produk.dataproduk')->with('error', 'Data tidak ditemukan!');
    }

    if ($produk->foto_produk && File::exists(public_path($produk->foto_produk))) {
        File::delete(public_path($produk->foto_produk));
    }

    $produk->delete();

    return redirect()->route('produk.dataproduk')->with('success', 'Jasa berhasil dihapus!');
}

}
