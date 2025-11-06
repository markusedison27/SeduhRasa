<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    
    // Nama tabel di database
    protected $table = 'menus'; 

    // Kolom yang dapat diisi
    protected $fillable = [
        'nama_menu',
        'deskripsi',
        'harga',
        'kategori', // Misalnya: Makanan, Minuman, Snack
        // Tambahkan kolom lain jika diperlukan
    ];
}