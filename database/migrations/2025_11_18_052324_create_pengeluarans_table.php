<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengeluarans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('kategori')->nullable();     // misal: bahan baku, listrik, sewa, gaji
            $table->string('keterangan')->nullable();   // catatan tambahan
            $table->bigInteger('nominal');              // simpan dalam rupiah
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengeluarans');
    }
};
