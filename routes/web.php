<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\OrderController;

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
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.proses');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegistrasiController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegistrasiController::class, 'registrasi'])->name('register.proses');


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/datapengguna', [UserController::class, 'tampilData'])->name('pengguna.datapengguna');
    Route::post('/tambahdatapengguna', [UserController::class, 'tambahData'])->name('pengguna.tambah');
Route::put('/perbaruipengguna/{id_user}', [UserController::class, 'perbaruiData'])->name('pengguna.perbarui');
Route::delete('/hapuspengguna/{id_user}', [UserController::class, 'hapusData'])->name('pengguna.hapus');

Route::get('/dataproduk', [ProdukController::class, 'tampilProduk'])->name('produk.dataproduk');
Route::post('/tambahdataproduk', [ProdukController::class, 'tambahProduk'])->name('produk.tambah');
Route::put('/perbaruiproduk/{id_produk}', [ProdukController::class, 'perbaruiProduk'])->name('produk.perbarui');
Route::delete('/hapusproduk/{id_produk}', [ProdukController::class, 'hapusProduk'])->name('produk.hapus');

Route::get('/dataorder', [OrderController::class, 'tampilanPemesan'])->name('order.datapemesanan');
Route::put('/order/status/{id}', [OrderController::class, 'updateStatusPemesanan'])->name('order.updateStatus');
Route::post('/kirimwa/{id}', [OrderController::class, 'kirimWA'])->name('order.kirimwa');


});


//pelanggan
Route::get('/', [PelangganController::class, 'tampilProdukPelanggan'])->name('pelanggan.produk'); // untuk halaman utama

Route::middleware(['auth', 'role:pelanggan'])->group(function () {
    Route::get('/home', [PelangganController::class, 'tampilProdukPelanggan'])->name('pelanggan.home'); // ⬅ ganti nama route-nya
    Route::get('/pesan/{id_produk}', [PelangganController::class, 'formPemesanan'])->name('form.pemesanan');
    Route::post('/pesan/{id_produk}', [PemesananController::class, 'simpan'])->name('pemesanan.simpan');
    Route::get('/riwayat', [PemesananController::class, 'riwayat'])->name('pelanggan.riwayat')->middleware('auth');
    Route::post('/pelunasan/upload/{id}', [PemesananController::class, 'pelunasan'])->name('pelunasan.kirim');
    Route::get('/kategori/{kategori}', [PelangganController::class, 'byKategori'])->name('produk.kategori');



});

// Route::get('/', function () {
//     return view('auth.login');
// });
