<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi mass assignment
     * DISESUAIKAN DENGAN STRUKTUR TABEL YANG ADA
     */
    protected $fillable = [
        'kode_order',        // varchar(255) - kode unik order
        'customer_name',     // varchar(255) - nama pelanggan
        'subtotal',          // bigint(20) - total harga
        'status',            // varchar(255) - status: pending/proses/selesai/batal
        'metode_pembayaran', // varchar(255) - cod/dana
        'no_meja',           // varchar(255) - nomor meja
        'meja_nomor',        // varchar(255) - alias untuk no_meja (jika ada)
        'keterangan',        // text - detail menu yang dipesan
        'waktu_order',       // datetime - waktu order dibuat (opsional)
    ];

    /**
     * Cast tipe data
     */
    protected $casts = [
        'subtotal'     => 'integer',
        'waktu_order'  => 'datetime',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
    ];

    /**
     * Accessor untuk kompatibilitas dengan code lama
     * Agar bisa pakai $order->nama_pelanggan meski kolom aslinya customer_name
     */
    public function getNamaPelangganAttribute()
    {
        return $this->customer_name;
    }

    public function getTotalHargaAttribute()
    {
        return $this->subtotal;
    }

    public function getMenuDipesanAttribute()
    {
        return $this->keterangan;
    }

    /**
     * Mutator untuk set nilai jika ada code yang masih pakai nama lama
     */
    public function setNamaPelangganAttribute($value)
    {
        $this->attributes['customer_name'] = $value;
    }

    public function setTotalHargaAttribute($value)
    {
        $this->attributes['subtotal'] = $value;
    }

    public function setMenuDipesanAttribute($value)
    {
        $this->attributes['keterangan'] = $value;
    }
}