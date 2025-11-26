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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->string('kode_order');
            $table->string('customer_name');
            $table->text('keterangan')->nullable(); // menu yang dipesan
            $table->bigInteger('subtotal')->default(0);
            $table->string('metode_pembayaran')->nullable();
            $table->string('no_meja')->nullable();
            $table->timestamp('transaction_date')->nullable(); // waktu order selesai
            $table->timestamps();

            // Index untuk optimasi query
            $table->index('kode_order');
            $table->index('transaction_date');
            $table->index('customer_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};