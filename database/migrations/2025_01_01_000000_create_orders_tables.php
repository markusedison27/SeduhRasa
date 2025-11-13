<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $t) {
            $t->id();
            $t->string('customer_name')->nullable();
            $t->unsignedBigInteger('subtotal'); // rupiah
            $t->string('status')->default('pending'); // pending/paid/cancelled
            $t->timestamps();
        });

        Schema::create('order_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('order_id')->constrained()->cascadeOnDelete();
            $t->string('name');
            $t->unsignedInteger('qty');
            $t->unsignedBigInteger('price'); // rupiah
            $t->enum('serve', ['dingin','panas'])->nullable();
            $t->unsignedBigInteger('line_total'); // price*qty
            $t->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
