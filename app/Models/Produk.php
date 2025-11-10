<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    
    // Nama tabel di database
    protected $table = 'produk'; 

    // Kolom yang dapat diisi
    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'harga',
        'kategori', // Misalnya: Makanan, Minuman, Snack
    ];
}