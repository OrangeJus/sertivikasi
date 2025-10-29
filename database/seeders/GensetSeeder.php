<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GensetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 2. Insert 10 data ke tabel 'gensets'
        DB::table('gensets')->insert([
            // Data 1
            [
                'nama_genset' => 'Honda 10KVA',
                'kapasitas' => '10 KVA',
                'harga_sewa' => 150000,
                'status' => 'tersedia', // OK
                'deskripsi' => 'Genset portable untuk event kecil',
                'image' => 'gensets/Gambar 1.jpg', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Data 2
            [
                'nama_genset' => 'Yamaha 20KVA',
                'kapasitas' => '20 KVA',
                'harga_sewa' => 250000,
                'status' => 'disewa', // OK
                'deskripsi' => 'Genset medium untuk backup toko',
                'image' => 'gensets/Gambar 2.jpg', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Data 3
            [
                'nama_genset' => 'Perkins 50KVA Silent',
                'kapasitas' => '50 KVA',
                'harga_sewa' => 500000,
                'status' => 'tersedia', // OK
                'deskripsi' => 'Genset silent untuk industri skala kecil atau acara outdoor',
                'image' => 'gensets/Gambar 3.jpg', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Data 4
            [
                'nama_genset' => 'Cummins 100KVA Open',
                'kapasitas' => '100 KVA',
                'harga_sewa' => 850000,
                'status' => 'rusak', // DIUBAH dari 'maintenance'
                'deskripsi' => 'Genset open type untuk proyek konstruksi besar',
                'image' => 'gensets/Gambar 4.jpeg', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Data 5
            [
                'nama_genset' => 'Mitsubishi 30KVA',
                'kapasitas' => '30 KVA',
                'harga_sewa' => 350000,
                'status' => 'tersedia', // OK
                'deskripsi' => 'Genset silent handal dan irit bahan bakar',
                'image' => 'gensets/Gambar 5.jpg', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Data 6
            [
                'nama_genset' => 'Yanmar 15KVA Silent',
                'kapasitas' => '15 KVA',
                'harga_sewa' => 200000,
                'status' => 'tersedia', // OK
                'deskripsi' => 'Genset super silent, cocok untuk cafe atau restoran',
                'image' => 'gensets/Gambar 1.jpg', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Data 7
            [
                'nama_genset' => 'Kubota 25KVA Open',
                'kapasitas' => '25 KVA',
                'harga_sewa' => 300000,
                'status' => 'disewa', // OK
                'deskripsi' => 'Genset diesel open type, handal untuk bengkel',
                'image' => 'gensets/Gambar 2.jpg', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Data 8
            [
                'nama_genset' => 'Firman 5KVA Portable',
                'kapasitas' => '5 KVA',
                'harga_sewa' => 100000,
                'status' => 'tersedia', // OK
                'deskripsi' => 'Genset bensin portable sangat ringan untuk kebutuhan darurat',
                'image' => 'gensets/Gambar 3.jpg', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Data 9
            [
                'nama_genset' => 'Caterpillar 250KVA',
                'kapasitas' => '250 KVA',
                'harga_sewa' => 2000000,
                'status' => 'tersedia', // OK
                'deskripsi' => 'Genset kapasitas besar untuk backup pabrik atau data center',
                'image' => 'gensets/Gambar 4.jpeg', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Data 10
            [
                'nama_genset' => 'Deutz 80KVA Silent',
                'kapasitas' => '80 KVA',
                'harga_sewa' => 700000,
                'status' => 'rusak', // DIUBAH dari 'maintenance'
                'deskripsi' => 'Genset diesel silent buatan Jerman, performa tinggi',
                'image' => 'gensets/Gambar 5.jpg', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 3. Insert data ke tabel pivot 'category_genset'
        // (Ini tidak berubah dari sebelumnya)
        DB::table('category_genset')->insert([
            ['genset_id' => 1, 'category_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['genset_id' => 1, 'category_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['genset_id' => 2, 'category_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['genset_id' => 3, 'category_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['genset_id' => 3, 'category_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['genset_id' => 4, 'category_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['genset_id' => 4, 'category_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['genset_id' => 5, 'category_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['genset_id' => 5, 'category_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['genset_id' => 5, 'category_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['genset_id' => 6, 'category_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['genset_id' => 6, 'category_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['genset_id' => 7, 'category_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['genset_id' => 7, 'category_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['genset_id' => 8, 'category_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['genset_id' => 9, 'category_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['genset_id' => 9, 'category_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['genset_id' => 10, 'category_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['genset_id' => 10, 'category_id' => 4, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}