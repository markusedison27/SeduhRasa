<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('kode_order')->unique();
            $table->string('status')->default('pending');     // pending | diproses | siap | selesai | batal
            $table->string('customer_name')->nullable();
            $table->string('meja_nomor')->nullable();
            $table->unsignedBigInteger('subtotal')->default(0);
            $table->dateTime('waktu_order')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
