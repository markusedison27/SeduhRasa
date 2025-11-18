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
        Schema::table('users', function (Blueprint $table) {
            // tambahkan kolom role & owner_id kalau belum ada
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('staff')->after('email');
            }

            if (!Schema::hasColumn('users', 'owner_id')) {
                $table->unsignedBigInteger('owner_id')->nullable()->after('role');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // hapus kolom kalau ada
            if (Schema::hasColumn('users', 'owner_id')) {
                $table->dropColumn('owner_id');
            }

            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
