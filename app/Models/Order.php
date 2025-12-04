<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    
    // Sesuaikan dengan struktur database Anda
    protected $primaryKey = 'id'; // atau 'kode_order' jika itu primary key
    
    public $timestamps = true; // Gunakan created_at & updated_at

    protected $fillable = [
        'kode_order',
        'status',
        'metode_pembayaran',
        'no_meja',
        'customer_name',
        'meja_nomor', 
        'subtotal',
        'waktu_order',
        'keterangan',
    ];

    // Accessor untuk kompatibilitas dengan kode lama
    public function getNamaPelangganAttribute()
    {
        return $this->customer_name;
    }

    public function getNoMejaAttribute()
    {
        return $this->meja_nomor ?? $this->no_meja;
    }

    public function getTotalHargaAttribute()
    {
        return $this->subtotal;
    }

    // Mutator untuk menyimpan data
    public function setNamaPelangganAttribute($value)
    {
        $this->attributes['customer_name'] = $value;
    }

    public function setNoMejaAttribute($value)
    {
        $this->attributes['meja_nomor'] = $value;
    }

    public function setTotalHargaAttribute($value)
    {
        $this->attributes['subtotal'] = $value;
    }

    // Relasi ke order_items (jika ada)
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    // Method untuk mendapatkan menu yang dipesan
    public function getMenuDipesanAttribute()
    {
        // Jika data disimpan di tabel order_items
        if ($this->items()->count() > 0) {
            return $this->items->map(function($item) {
                return "{$item->name} x{$item->qty}";
            })->implode(', ');
        }
        
        // Jika tidak ada relasi, return string kosong
        return $this->keterangan ?? '';
    }
}