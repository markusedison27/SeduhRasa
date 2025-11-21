// database/migrations/xxxx_xx_xx_xxxxxx_create_payment_settings_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payment_settings', function (Blueprint $table) {
            $table->id();
            $table->string('dana_number')->nullable();
            $table->string('dana_name')->nullable();
            $table->string('dana_qr_path')->nullable(); // path gambar QR di storage
            $table->string('ovo_number')->nullable();
            $table->string('ovo_name')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_settings');
    }
};
