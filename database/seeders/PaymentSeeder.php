<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        // create a sample payment for seeded rental if exists
        if (DB::table('rentals')->count() > 0) {
            $rental = DB::table('rentals')->first();
            DB::table('payments')->insert([
                'rental_id' => $rental->id,
                'payment_date' => now(),
                'amount' => $rental->total_harga,
                'payment_method' => 'transfer',
                'payment_proof' => null,
                'payment_status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
