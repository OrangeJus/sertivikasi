<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
public function run(): void
{
    User::create([
        'name' => 'Admin Genset',
        'email' => 'admin@genset.test',
        'password' => Hash::make('admin123'),
        'role' => 'admin',
    ]);

    // contoh user biasa
    User::create([
        'name' => 'Budi',
        'email' => 'budi@user.test',
        'password' => Hash::make('user123'),
        'role' => 'user',
    ]);
}
}
