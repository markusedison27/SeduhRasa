<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // kolom pelanggan_id setelah kolom id (boleh bebas posisinya)
            $table->unsignedBigInteger('pelanggan_id')->nullable()->after('id');

            // foreign key ke tabel pelanggans
            $table->foreign('pelanggan_id')
                  ->references('id')
                  ->on('pelanggans')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['pelanggan_id']);
            $table->dropColumn('pelanggan_id');
        });
    }
};
