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

            // Kolom untuk menyimpan path/lokasi file QR Code
            $table->string('file_path')->unique();

            // Kolom untuk status aktif/tidak aktif (sesuai kode di OrderController)
            // Defaultnya disetel ke false/0 saat pertama dibuat
            $table->boolean('is_active')->default(false);

            // Kolom opsional: untuk mengaitkan QR Code ke entitas lain (misalnya, Order)
            // Jika diperlukan, tambahkan foreign key di sini
            // Contoh: $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');

            // Kolom untuk catatan/deskripsi tambahan
            $table->text('notes')->nullable();
            
            // Kolom created_at dan updated_at
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