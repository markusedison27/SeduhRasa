<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'id';
    public $timestamps = true;

    // Sesuaikan dengan kolom yang benar-benar ada di tabel orders
    protected $fillable = [
        'pelanggan_id',
        'kode_order',
        'status',
        'metode_pembayaran',
        'no_meja',        // kolom utama untuk nomor meja
        'customer_name',
        'subtotal',
        'waktu_order',
        'keterangan',
    ];

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    // Alias lama: $order->nama_pelanggan
    public function getNamaPelangganAttribute()
    {
        return $this->customer_name;
    }

    // Alias lama: $order->no_meja (dengan fallback ke meja_nomor jika ada)
    public function getNoMejaAttribute($value)
    {
        // $value adalah nilai dari kolom no_meja (kalau ada di DB)
        if (!is_null($value)) {
            return $value;
        }

        // fallback kalau dulu pernah pakai kolom meja_nomor
        return $this->attributes['meja_nomor'] ?? null;
    }

    // Alias lama: $order->total_harga
    public function getTotalHargaAttribute()
    {
        return $this->subtotal;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function setNamaPelangganAttribute($value)
    {
        $this->attributes['customer_name'] = $value;
    }

    public function setNoMejaAttribute($value)
    {
        // Simpan ke kolom no_meja (kolom utama yang dipakai controller)
        $this->attributes['no_meja'] = $value;
    }

    public function setTotalHargaAttribute($value)
    {
        $this->attributes['subtotal'] = $value;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | EXTRA ATTRIBUTE
    |--------------------------------------------------------------------------
    */

    // $order->menu_dipesan
    public function getMenuDipesanAttribute()
    {
        // Jika data detail disimpan di tabel order_items
        if ($this->relationLoaded('items') || $this->items()->exists()) {
            return $this->items
                ->map(function ($item) {
                    return "{$item->name} x{$item->qty}";
                })
                ->implode(', ');
        }

        // Kalau tidak ada relasi, pakai keterangan sebagai fallback
        return $this->keterangan ?? '';
    }
}
