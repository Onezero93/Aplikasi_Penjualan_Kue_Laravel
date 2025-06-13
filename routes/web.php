<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdukController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/datapengguna', [UserController::class, 'tampilData'])->name('pengguna.datapengguna');
Route::post('/tambahdatapengguna', [UserController::class, 'tambahData'])->name('pengguna.tambah');
Route::put('/perbaruipengguna/{id_user}', [UserController::class, 'perbaruiData'])->name('pengguna.perbarui');
Route::delete('/hapuspengguna/{id_user}', [UserController::class, 'hapusData'])->name('pengguna.hapus');

Route::get('/dataproduk', [ProdukController::class, 'tampilProduk'])->name('produk.dataproduk');
Route::post('/tambahdataproduk', [ProdukController::class, 'tambahProduk'])->name('produk.tambah');
Route::put('/perbaruiproduk/{id_produk}', [ProdukController::class, 'perbaruiProduk'])->name('produk.perbarui');
        // Route::get('/detailjasa/{id_jasa}', [JasaController::class, 'detailJasa'])->name('jasa.detail');
Route::delete('/hapusproduk/{id_produk}', [ProdukController::class, 'hapusProduk'])->name('produk.hapus');

// Route::get('/', function () {
//     return view('datapengguna.pengguna');
// });
