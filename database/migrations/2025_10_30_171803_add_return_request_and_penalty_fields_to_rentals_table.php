<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            // Return request fields
            $table->enum('status_pengembalian', ['diminta', 'disetujui', 'ditolak'])->nullable()->after('status');
            $table->dateTime('tanggal_request_pengembalian')->nullable()->after('status_pengembalian');
            $table->text('catatan_pengembalian_user')->nullable()->after('tanggal_request_pengembalian');
            $table->text('catatan_pengembalian_admin')->nullable()->after('catatan_pengembalian_user');
            
            // Penalty payment fields
            $table->boolean('denda_dibayar')->default(false)->after('denda');
            $table->dateTime('tanggal_bayar_denda')->nullable()->after('denda_dibayar');
            $table->string('bukti_bayar_denda')->nullable()->after('tanggal_bayar_denda');
            $table->foreignId('denda_verified_by')->nullable()->constrained('users')->nullOnDelete()->after('bukti_bayar_denda');
            $table->dateTime('denda_verified_at')->nullable()->after('denda_verified_by');
        });
    }

    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropForeign(['denda_verified_by']);
            $table->dropColumn([
                'status_pengembalian',
                'tanggal_request_pengembalian',
                'catatan_pengembalian_user',
                'catatan_pengembalian_admin',
                'denda_dibayar',
                'tanggal_bayar_denda',
                'bukti_bayar_denda',
                'denda_verified_by',
                'denda_verified_at'
            ]);
        });
    }
};