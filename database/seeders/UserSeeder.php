<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 2. Buat 3 Admin
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@genset.test',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'Admin Staff',
            'email' => 'staff@genset.test',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'Admin Gudang',
            'email' => 'gudang@genset.test',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // 3. Buat 7 User
        User::create([
            'name' => 'Budi Setiawan',
            'email' => 'budi@user.test',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);
        User::create([
            'name' => 'Ani Lestari',
            'email' => 'ani@user.test',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);
        User::create([
            'name' => 'Candra Wijaya',
            'email' => 'candra@user.test',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);
        User::create([
            'name' => 'Dewi Sartika',
            'email' => 'dewi@user.test',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);
        User::create([
            'name' => 'Eko Prasetyo',
            'email' => 'eko@user.test',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);
        User::create([
            'name' => 'Fajar Nugroho',
            'email' => 'fajar@user.test',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);
        User::create([
            'name' => 'Gita Permata',
            'email' => 'gita@user.test',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);
    }
}