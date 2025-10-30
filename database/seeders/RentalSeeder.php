<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon; // <-- Tambahkan ini

class RentalSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('rentals')->insert([
            // Data 1 (yang sudah ada)
            [
                'user_id' => 1, // User Admin
                'genset_id' => 2, // Yamaha 20KVA
                'tanggal_mulai' => now()->addDays(1)->toDateString(),
                'tanggal_selesai' => now()->addDays(3)->toDateString(),
                'total_harga' => 250000 * 3, // Harga Yamaha 250k
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Data 2 (Tambahan yang Anda minta)
            [
                'user_id' => 4, // User Budi (ID 4)
                'genset_id' => 3, // Perkins 50KVA (ID 3)
                'tanggal_mulai' => Carbon::create(2025, 10, 27)->toDateString(), // 27 Okt 2025
                'tanggal_selesai' => Carbon::create(2025, 10, 29)->toDateString(), // 29 Okt 2025
                'total_harga' => 500000 * 3, // Harga Perkins (500k) * 3 hari
                'status' => 'active', // Sudah lewat
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}