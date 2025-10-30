<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RentalSeeder extends Seeder
{
    public function run(): void
    {
        // contoh seed minimal — sesuaikan id user/genset di lingkungan Anda
        DB::table('rentals')->insert([
            [
                'user_id' => 1,
                'genset_id' => 2,
                'tanggal_mulai' => now()->addDays(1)->toDateString(),
                'tanggal_selesai' => now()->addDays(3)->toDateString(),
                'total_harga' => 250000 * 3,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
