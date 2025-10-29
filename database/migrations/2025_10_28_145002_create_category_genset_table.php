<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('category_genset', function (Blueprint $table) {
            $table->id();
            $table->foreignId('genset_id')->constrained('gensets')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['genset_id','category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_genset');
    }
};
