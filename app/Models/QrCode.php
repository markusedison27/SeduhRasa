<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     */
    protected $table = 'qr_codes';

    /**
     * Kolom yang bisa diisi secara mass assignment
     */
    protected $fillable = [
        'file_path',
        'payment_method',
        'is_active',
        'description',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope: Ambil QR Code yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Accessor: Dapatkan URL lengkap dari file_path
     */
    public function getFullUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }

    /**
     * Method: Nonaktifkan semua QR Code lainnya
     */
    public static function deactivateAll()
    {
        self::query()->update(['is_active' => false]);
    }

    /**
     * Method: Aktifkan QR Code ini dan nonaktifkan yang lain
     */
    public function activate()
    {
        self::deactivateAll();
        $this->update(['is_active' => true]);
    }
}