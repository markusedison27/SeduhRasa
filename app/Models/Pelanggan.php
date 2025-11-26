<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order; // <--- TAMBAH INI

class Pelanggan extends Model
{
    use HasFactory;

    // pakai tabel pelanggans (defaultnya memang pelanggans)
    protected $table = 'pelanggans';

    // field yang boleh diisi mass assignment
    protected $fillable = [
        'nama',
        'alamat',
        'telepon',
        'email',
    ];

    // RELASI: satu pelanggan punya banyak order
    public function orders()
    {
        return $this->hasMany(Order::class, 'pelanggan_id');
    }
}
