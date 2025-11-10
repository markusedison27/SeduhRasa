<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    
    protected $fillable = [
        'kode_order',
        'status', // Misalnya: Pending, Diproses, Siap Diambil
        'meja_nomor',
        'waktu_order',
        'keterangan',
    ];
}