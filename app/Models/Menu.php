<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';

    protected $fillable = [
        'nama_menu',
        'kategori',
        'gambar',       // ⬅️ kolom gambar di database
        'suhu',
        'harga',
        'stok',
        'group',
        'image',        // kalau masih dipakai di tempat lain biarin aja
        'description',
        'serve_options',
    ];

    protected $casts = [
        'serve_options' => 'array',
        'stok'          => 'integer',
    ];

    public function getNamaAttribute()
    {
        return $this->nama_menu;
    }

    /**
     * Apakah stok masih ada?
     */
    public function isAvailable(): bool
    {
        return $this->stok > 0;
    }

    /**
     * Kurangi stok
     */
    public function decreaseStock(int $quantity): bool
    {
        if ($this->stok >= $quantity) {
            $this->stok -= $quantity;
            return $this->save();
        }

        return false;
    }

    /**
     * Tambah stok
     */
    public function increaseStock(int $quantity): bool
    {
        $this->stok += $quantity;
        return $this->save();
    }
}
