public function up(): void
{
    Schema::table('orders', function (Blueprint $table) {
        $table->string('no_meja')->nullable()->after('nama_pelanggan');
    });
}

public function down(): void
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn('no_meja');
    });
}
