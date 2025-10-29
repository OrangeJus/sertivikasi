<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gensets', function (Blueprint $table) {
            $table->id();
            $table->string('nama_genset');
            $table->string('kapasitas')->nullable();
            $table->enum('status', ['tersedia','disewa','rusak'])->default('tersedia');
            $table->decimal('harga_sewa', 12, 2)->default(0);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
            // $table->softDeletes(); // uncomment jika mau soft delete
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gensets');
    }
};
