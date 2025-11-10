<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel pelanggans.
     */
    public function up(): void
    {
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('nama'); // Nama pelanggan
            $table->string('alamat')->nullable(); // Alamat pelanggan
            $table->string('telepon')->nullable(); // Nomor telepon (sinkron dgn model)
            $table->string('email')->unique()->nullable(); // Email (opsional & unik)
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Rollback (hapus tabel jika dibatalkan).
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggans');
    }
};
