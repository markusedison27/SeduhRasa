<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique(); // contoh: TRX001
            $table->string('nama_pelanggan');           // nama pembeli
            $table->decimal('total_harga', 10, 2);      // total harga
            $table->date('tanggal_transaksi');          // tanggal transaksi
            $table->timestamps();                       // created_at & updated_at
        });
    }

    /**
     * Kembalikan (hapus tabel jika rollback).
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
