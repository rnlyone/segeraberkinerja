<?php

namespace Database\Seeders;

use App\Models\Satuan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'jenis_satuan' => 'ssh',
                'kode_kelompok' => '1.1.12.01.01.0001',
                'uraian_kelompok' => 'Bahan Bangunan dan Konstruksi',
                'id_standar' => 6032941,
                'kode_barang' => '1.1.12.01.01.0001.00002',
                'nama_item' => 'Semen',
                'spesifikasi' => 'Tonasa',
                'satuan' => 'Zak',
                'harga' => 85000,
                'kode_rekening' => '5.1.02.01.01.0001',
            ],
            [
                'jenis_satuan' => 'ssh',
                'kode_kelompok' => '1.1.12.01.01.0001',
                'uraian_kelompok' => 'Bahan Bangunan dan Konstruksi',
                'id_standar' => 6032941,
                'kode_barang' => '1.1.12.01.01.0001.00003',
                'nama_item' => 'Semen (Zona I)',
                'spesifikasi' => 'Tonasa',
                'satuan' => 'Zak',
                'harga' => 83500,
                'kode_rekening' => '5.1.02.01.01.0001',
            ],
            [
                'jenis_satuan' => 'ssh',
                'kode_kelompok' => '1.1.12.01.01.0001',
                'uraian_kelompok' => 'Bahan Bangunan dan Konstruksi',
                'id_standar' => 6032941,
                'kode_barang' => '1.1.12.01.01.0001.00004',
                'nama_item' => 'Semen (Zona II)',
                'spesifikasi' => 'Bosowa',
                'satuan' => 'Zak',
                'harga' => 78000,
                'kode_rekening' => '5.1.02.01.01.0001',
            ],
            [
                'jenis_satuan' => 'ssh',
                'kode_kelompok' => '1.1.12.01.01.0001',
                'uraian_kelompok' => 'Bahan Bangunan dan Konstruksi',
                'id_standar' => 6032941,
                'kode_barang' => '1.1.12.01.01.0001.00005',
                'nama_item' => 'Semen (Zona III)',
                'spesifikasi' => 'Bosowa',
                'satuan' => 'Zak',
                'harga' => 74000,
                'kode_rekening' => '5.1.02.01.01.0001',
            ],
        ];

        // Masukkan data ke dalam tabel menggunakan fungsi create
        foreach ($data as $item) {
            Satuan::create($item);
        }
    }
}
