<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Nama tabel


    // Kolom yang boleh diisi mass assignment
 protected $fillable = [
    'nama_pelanggan',
    'menu_dipesan',
    'jumlah',
    'total_harga',
    'status',
    'metode_pembayaran',   // <---
];
}
