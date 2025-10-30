<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->decimal('denda', 12, 2)->default(0)->after('total_harga');
            $table->integer('hari_keterlambatan')->default(0)->after('denda');
            $table->dateTime('tanggal_pengembalian_aktual')->nullable()->after('tanggal_selesai');
        });
    }

    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn(['denda', 'hari_keterlambatan', 'tanggal_pengembalian_aktual']);
        });
    }
};