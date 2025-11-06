<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    
    protected $fillable = [
        'kode_transaksi',
        'pelanggan_id',
        'total_harga',
        'jumlah_bayar',
        'kembalian',
        'status', // Misalnya: Selesai, Dibatalkan
    ];
}