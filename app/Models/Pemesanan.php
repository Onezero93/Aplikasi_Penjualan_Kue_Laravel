<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan';
    protected $primaryKey = 'id_pemesanan';

    protected $fillable = [
        'user_id',
        'produk_id',
        'tanggal_ambil',
        'jumlah',
        'total_harga',
        'metode_pembayaran',
        'jenis_pembayaran',
        'nominal_dp',
        'sisa_pembayaran',
        'bukti_transfer',
        'status',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    // Relasi ke Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id_produk');
    }
}
