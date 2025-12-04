// app/Models/Setting.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    
    // Tentukan nama tabel
    protected $table = 'settings'; 
    
    // Tentukan kolom yang bisa diisi (key dan value)
    protected $fillable = ['key', 'value']; 
}