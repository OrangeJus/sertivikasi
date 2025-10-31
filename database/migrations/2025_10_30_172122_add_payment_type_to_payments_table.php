<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->enum('payment_type', ['rental', 'penalty'])->default('rental')->after('rental_id');
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete()->after('payment_status');
            $table->dateTime('verified_at')->nullable()->after('verified_by');
            $table->text('rejection_reason')->nullable()->after('verified_at');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropColumn(['payment_type', 'verified_by', 'verified_at', 'rejection_reason']);
        });
    }
};