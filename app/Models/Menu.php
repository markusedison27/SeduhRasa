<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'nama_menu',
        'harga',
        'group',
        'image',
        'description',
        'serve_options',
        'stok', // ✅ TAMBAHKAN INI
    ];

    // Cast JSON untuk serve_options
    protected $casts = [
        'serve_options' => 'array',
        'stok' => 'integer',
    ];

    // Accessor agar bisa pakai $menu->nama (opsional)
    public function getNamaAttribute()
    {
        return $this->nama_menu;
    }

    /**
     * Cek apakah menu tersedia (stok > 0)
     */
    public function isAvailable(): bool
    {
        return $this->stok > 0;
    }

    /**
     * Kurangi stok menu
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
     * Tambah stok menu
     */
    public function increaseStock(int $quantity): bool
    {
        $this->stok += $quantity;
        return $this->save();
    }
}