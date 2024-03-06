<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'barang_id' => 1,
                'kategori_id' => 1, // Makanan
                'barang_kode' => 'br1',
                'barang_nama' => 'Nabati',
                'harga_beli' => 5000,
                'harga_jual' => 10000
            ],
            [
                'barang_id' => 2,
                'kategori_id' => 2, // Alat Tulis
                'barang_kode' => 'br2',
                'barang_nama' => 'Pensil',
                'harga_beli' => 1000,
                'harga_jual' => 3000
            ],
            [
                'barang_id' => 3,
                'kategori_id' => 3, // Barang-barang Hobi
                'barang_kode' => 'br3',
                'barang_nama' => 'Shuttlecock',
                'harga_beli' => 157000,
                'harga_jual' => 321000
            ],
            [
                'barang_id' => 4,
                'kategori_id' => 4, // Barang Kecantikan
                'barang_kode' => 'br4',
                'barang_nama' => 'Lipstik',
                'harga_beli' => 15000,
                'harga_jual' => 25000
            ],
            [
                'barang_id' => 5,
                'kategori_id' => 5, // Alat Elektronik
                'barang_kode' => 'br5',
                'barang_nama' => 'Smartphone',
                'harga_beli' => 5000000,
                'harga_jual' => 7000000
            ],
            [
                'barang_id' => 6,
                'kategori_id' => 1, // Makanan
                'barang_kode' => 'br6',
                'barang_nama' => 'Biskuit',
                'harga_beli' => 3000,
                'harga_jual' => 6000
            ],
            [
                'barang_id' => 7,
                'kategori_id' => 2, // Alat Tulis
                'barang_kode' => 'br7',
                'barang_nama' => 'Bolpoin',
                'harga_beli' => 500,
                'harga_jual' => 1500
            ],
            [
                'barang_id' => 8,
                'kategori_id' => 3, // Barang-barang Hobi
                'barang_kode' => 'br8',
                'barang_nama' => 'Painting Set',
                'harga_beli' => 25000,
                'harga_jual' => 45000
            ],
            [
                'barang_id' => 9,
                'kategori_id' => 4, // Barang Kecantikan
                'barang_kode' => 'br9',
                'barang_nama' => 'Conditioner',
                'harga_beli' => 12000,
                'harga_jual' => 20000
            ],
            [
                'barang_id' => 10,
                'kategori_id' => 5, // Alat Elektronik
                'barang_kode' => 'br10',
                'barang_nama' => 'Laptop',
                'harga_beli' => 8000000,
                'harga_jual' => 10000000
            ],
        ];
        DB::table('m_barang')->insert($data);
    }
}