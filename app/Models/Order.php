<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Order extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi mass-assignment
    protected $fillable = [
        'kode_order',
        'status',        // pending | diproses | siap | selesai | batal (bebas kamu tentukan)
        'customer_name', // opsional
        'meja_nomor',    // opsional
        'subtotal',      // integer rupiah
        'waktu_order',   // datetime
        'keterangan',    // catatan opsional
    ];

    // Casting kolom
    protected $casts = [
        'waktu_order' => 'datetime',
        'subtotal'    => 'integer',
    ];

    // Relasi: 1 Order punya banyak OrderItem
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Auto generate kode_order saat create (jika belum diisi)
    protected static function booted()
    {
        static::creating(function (Order $order) {
            if (empty($order->kode_order)) {
                $order->kode_order = self::generateCode();
            }
            if (empty($order->waktu_order)) {
                $order->waktu_order = now();
            }
            if (empty($order->status)) {
                $order->status = 'pending';
            }
        });
    }

    // Helper pembuat kode mis. SR-20251112-0001
    public static function generateCode(): string
    {
        $prefix = 'SR-'.now()->format('Ymd').'-';
        $countToday = static::whereDate('created_at', now()->toDateString())->count() + 1;
        return $prefix . str_pad((string)$countToday, 4, '0', STR_PAD_LEFT);
    }

    // Total terhitung ulang dari items (kalau mau)
    public function computedSubtotal(): int
    {
        return (int) $this->items()->sum('line_total');
    }

    // Scope cepat filter status
    public function scopeStatus($q, string $status)
    {
        return $q->where('status', $status);
    }
}
