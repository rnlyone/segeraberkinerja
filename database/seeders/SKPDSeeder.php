<?php

namespace Database\Seeders;

use App\Models\SKPD;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SKPDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $skpds = [
            ["1.02.0.00.0.00.02.0000", "Dinas Kesehatan", "1"],
            ["2.09.0.00.0.00.12.0000", "Dinas Ketahanan Pangan", "1"],
            ["2.13.0.00.0.00.15.0000", "Dinas Pemberdayaan Masyarakat dan Desa", "1"],
            ["2.19.0.00.0.00.21.0000", "Dinas Kepemudaan dan Olahraga", "1"],
            ["5.02.0.00.0.00.33.0000", "Badan Pendapatan Daerah", "1"],
            ["5.05.0.00.0.00.36.0000", "Badan Penelitian dan Pengembangan", "1"],
            ["5.05.0.00.0.00.39.0000", "Badan Pengelolaan Keuangan dan Aset Daerah", "2"],
        ];

        foreach ($skpds as $i => $skpd) {
            SKPD::create([
                'kode' => $skpd[0],
                'nama_skpd' => $skpd[1],
                'foto_skpd' => 'default.jpg', // Ubah jika ada path foto tersedia
                'level_otoritas' => $skpd[2], // Atur level otoritas sesuai kebutuhan
            ]);
        }
    }
}
