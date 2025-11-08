<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel karyawan.
     */
    public function up(): void
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('nama'); // Nama karyawan
            $table->string('jabatan')->nullable(); // Jabatan, opsional
            $table->string('email')->unique()->nullable(); // Email unik (boleh kosong)
            $table->string('telepon')->nullable(); // Nomor telepon
            $table->string('alamat')->nullable(); // Alamat karyawan
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Rollback migrasi (hapus tabel jika dibatalkan).
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};
