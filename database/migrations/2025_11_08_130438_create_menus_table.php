<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            // Disarankan menggunakan 'name' untuk konvensi Model Laravel, tapi kita tetap pakai 'nama_menu'
            $table->string('nama_menu')->unique(); 
            // Kolom harga diubah menjadi Integer karena input Admin menggunakan nilai bulat (Rp 25.000)
            $table->integer('harga'); 
            
            // Kolom Fungsionalitas Aplikasi
            $table->string('group'); // Contoh: Coffee, Desserts, Mocktail & Tea
            $table->string('image')->nullable(); // Path foto menu (diperlukan untuk tampilan menu)
            $table->string('description')->nullable();
            $table->json('serve_options')->nullable(); // Contoh: ["Dingin", "Panas"]

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};