<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan tabel dulu
        Schema::disableForeignKeyConstraints();
        DB::table('categories')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('categories')->insert([
            [
                'nama_kategori' => 'Portable',
                'deskripsi' => 'Genset portable',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Silent',
                'deskripsi' => 'Genset silent type',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Open Type',
                'deskripsi' => 'Genset open type',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Diesel',
                'deskripsi' => 'Diesel engine',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambahkan kategori lain jika perlu
            [
                'nama_kategori' => 'Gasoline',
                'deskripsi' => 'Genset bensin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}