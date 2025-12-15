<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('qr_codes', function (Blueprint $table) {
            $table->id();
            $table->string('file_path'); // Path file QR Code di storage
            $table->string('payment_method')->default('dana'); // Metode pembayaran (dana, qris, dll)
            $table->boolean('is_active')->default(true); // Status aktif/non-aktif
            $table->text('description')->nullable(); // Deskripsi tambahan (opsional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_codes');
    }
};