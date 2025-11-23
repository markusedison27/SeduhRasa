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
            $table->string('nama'); // Nama karyawan (WAJIB)
            $table->enum('jabatan', ['Manajer', 'Kasir', 'Barista']); // Jabatan (WAJIB, dengan pilihan terbatas)
            $table->string('email')->unique(); // Email unik (WAJIB)
            $table->string('telepon', 15)->nullable(); // Nomor telepon (opsional)
            $table->text('alamat')->nullable(); // Alamat karyawan (opsional)
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