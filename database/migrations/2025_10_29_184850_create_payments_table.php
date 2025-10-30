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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_id')->constrained('rentals')->cascadeOnDelete();
            $table->dateTime('payment_date')->nullable();
            $table->decimal('amount', 10, 2)->default(0);
            $table->enum('payment_method', ['transfer','cash'])->default('transfer');
            $table->string('payment_proof')->nullable();
            $table->enum('payment_status', ['pending','paid','cancelled'])->default('pending');
            $table->timestamps();

            $table->unique('rental_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
