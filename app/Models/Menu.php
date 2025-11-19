<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'nama_menu',
        'kategori',
        'suhu',
        'harga',
        'gambar',
    ];

    // Accessor agar bisa pakai $menu->nama (opsional)
    public function getNamaAttribute()
    {
        return $this->nama_menu;
    }
}