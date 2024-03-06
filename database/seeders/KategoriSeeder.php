<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kategori_id' => 1,
                'kategori_kode' => 'mkn',
                'kategori_nama' => 'Makanan'
            ],
            [
                'kategori_id' => 2,
                'kategori_kode' => 'atk',
                'kategori_nama' => 'Alat Tulis Kantor'
            ],
            [
                'kategori_id' => 3,
                'kategori_kode' => 'hb',
                'kategori_nama' => 'Hobi'
            ],
            [
                'kategori_id' => 4,
                'kategori_kode' => 'kcn',
                'kategori_nama' => 'Kecantikan'
            ],
            [
                'kategori_id' => 5,
                'kategori_kode' => 'atel',
                'kategori_nama' => 'Alat Elektronik'
            ],
        ];
        DB::table('m_kategori')->insert($data);
    }
}
