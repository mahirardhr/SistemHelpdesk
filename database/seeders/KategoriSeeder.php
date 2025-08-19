<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kategoris')->insert([
            ['nama_kategori' => 'Software'],
            ['nama_kategori' => 'Hardware'],
            ['nama_kategori' => 'Jaringan'],
            ['nama_kategori' => 'Akun/Login'],
            ['nama_kategori' => 'Lainnya'],
        ]);
    }
}
