<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            if (!Schema::hasColumn('transaksi', 'status')) {
                $table->enum('status', ['Pending', 'Selesai', 'Batal'])
                      ->default('Pending')
                      ->after('total_harga'); // kalau bikin error, hapus after()
            }
        });
    }

    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            if (Schema::hasColumn('transaksi', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
