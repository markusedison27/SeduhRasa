<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;


    // Kolom yang dapat diisi
    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'harga',
        'kategori', // Misalnya: Makanan, Minuman, Snack
    ];
}