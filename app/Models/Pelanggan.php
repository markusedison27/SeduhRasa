<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    // ✅ Ikuti konvensi Laravel → pakai bentuk jamak
    protected $table = 'pelanggans';

    // ✅ Kolom yang bisa diisi lewat mass assignment
    protected $fillable = [
        'nama',
        'alamat',
        'telepon',
        'email',
    ];
}
