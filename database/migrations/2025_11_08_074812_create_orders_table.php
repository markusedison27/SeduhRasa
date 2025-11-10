<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel orders.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // primary key
            $table->string('nama_pelanggan'); // nama customer
            $table->string('menu_dipesan');   // nama menu yang dipesan
            $table->integer('jumlah');        // jumlah item
            $table->decimal('total_harga', 10, 2); // total harga pesanan
            $table->string('status')->default('pending'); // pending, selesai, batal
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Kembalikan (hapus) tabel orders jika rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
