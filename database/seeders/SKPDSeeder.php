<?php

namespace Database\Seeders;

use App\Models\SKPD;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            ["5.05.0.00.0.00.43.0000", "BLUD RS HM. DJafar Harun", "1", "admin.rsdh"],
            ["5.05.0.00.0.00.43.0000", "Dinas Pekerjaan Umum dan Penataan Ruang", "1", "admin.pupr"],
            ["5.05.0.00.0.00.43.0000", "Dinas Perumahan, Kawasan Pemukiman dan Pertanahan", "1", "admin.pkpp"],
            ["5.05.0.00.0.00.43.0000", "Dinas Satuan Polisi Pamong Praja", "1", "admin.satpolpp"],
            ["5.05.0.00.0.00.43.0000", "Dinas Pemadam Kebakaran", "1", "admin.damkar"],
            ["5.05.0.00.0.00.43.0000", "Badan Penanggulangan Bencana Daerah", "1", "admin.bpbd"],
            ["5.05.0.00.0.00.43.0000", "Dinas Sosial", "1", "admin.dinsos"],
            ["5.05.0.00.0.00.43.0000", "Dinas Tenaga Kerja dan Transmigrasi", "1", "admin.disnaker"],
            ["5.05.0.00.0.00.43.0000", "Dinas Pemberdayaan Perempuan dan Perlindungan Anak", "1", "admin.dpppa"],
            ["5.05.0.00.0.00.43.0000", "Dinas Lingkungan Hidup", "1", "admin.dlh"],
            ["5.05.0.00.0.00.43.0000", "Dinas Kependudukan dan Catatan Sipil", "1", "admin.dukcapil"],
            ["5.05.0.00.0.00.43.0000", "Dinas Pengendalian Penduduk dan Keluarga Berencana", "1", "admin.DPPKB"],
            ["5.05.0.00.0.00.43.0000", "Dinas Perhubungan", "1", "admin.dishub"],
            ["5.05.0.00.0.00.43.0000", "Dinas Komunikasi, Informasi dan Persandian", "1", "admin.diskominfo"],
            ["5.05.0.00.0.00.43.0000", "Dinas Koperasi, Usaha Kecil dan Menengah", "1", "admin.dkukm"],
            ["5.05.0.00.0.00.43.0000", "Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu", "1", "admin.dpmptsp"],
            ["5.05.0.00.0.00.43.0000", "Dinas Perpustakaan", "1", "admin.pustaka"],
            ["5.05.0.00.0.00.43.0000", "Dinas Kearsipan", "1", "admin.arsip"],
            ["5.05.0.00.0.00.43.0000", "Dinas Perikanan", "1", "admin.perikanan"],
            ["5.05.0.00.0.00.43.0000", "Dinas Pariwisata", "1", "admin.pariwisata"],
            ["5.05.0.00.0.00.43.0000", "Dinas Perkebunan dan Peternakan", "1", "admin.dkt"],
            ["5.05.0.00.0.00.43.0000", "Dinas Tanaman Pangan dan Hortikultura", "1", "admin.dtph"],
            ["5.05.0.00.0.00.43.0000", "Dinas Perdagangan", "1", "admin.disdag"],
            ["5.05.0.00.0.00.43.0000", "Dinas Perindustrian", "1", "admin.disperin"],
            ["5.05.0.00.0.00.43.0000", "Sekretariat Daerah Kabupaten Kolaka Utara", "1", "admin.sekda"],
            ["5.05.0.00.0.00.43.0000", "Sekretariat DPRD Kabupaten Kolaka Utara", "1", "admin.dprd"],
            ["5.05.0.00.0.00.43.0000", "Badan Perencanaan Pembangunan Daerah", "1", "admin.bappeda"],
            ["5.05.0.00.0.00.43.0000", "Badan Kepegawaian dan Pengembangan Sumber Daya Manusia", "1", "admin.bkpsdm"],
            ["5.05.0.00.0.00.43.0000", "Inspektorat Daerah Kabupaten Kolaka Utara", "1", "admin.inspektorat"],
            ["5.05.0.00.0.00.43.0000", "Kecamatan Wawo", "1", "admin.wawo"],
            ["5.05.0.00.0.00.43.0000", "Kecamatan Ranteangin", "1", "admin.ranteangin"],
            ["5.05.0.00.0.00.43.0000", "Kecamatan Lambai", "1", "admin.lambai"],
            ["5.05.0.00.0.00.43.0000", "Kecamatan Lasusua", "1", "admin.lasusua"],
            ["5.05.0.00.0.00.43.0000", "Kecamatan Katoi", "1", "admin.katoi"],
            ["5.05.0.00.0.00.43.0000", "Kecamatan Kodeoha", "1", "admin.kodeoha"],
            ["5.05.0.00.0.00.43.0000", "Kecamatan Tiwu", "1", "admin.tiwu"],
            ["5.05.0.00.0.00.43.0000", "Kecamatan Ngapa", "1", "admin.ngapa"],
            ["5.05.0.00.0.00.43.0000", "Kecamatan Watunohu", "1", "admin.watunohu"],
            ["5.05.0.00.0.00.43.0000", "Kecamatan Pakue", "1", "admin.pakue"],
            ["5.05.0.00.0.00.43.0000", "Kecamatan Pakue Tengah", "1", "admin.pakuetengah"],
            ["5.05.0.00.0.00.43.0000", "Kecamatan Pakue Utara", "1", "admin.pakueutara"],
            ["5.05.0.00.0.00.43.0000", "Kecamatan Batu Putih", "1", "admin.batuputih"],
            ["5.05.0.00.0.00.43.0000", "Kecamatan Porehu", "1", "admin.porehu"],
            ["5.05.0.00.0.00.43.0000", "Kecamatan Tolala", "1", "admin.tolala"],
            ["5.05.0.00.0.00.43.0000", "Badan Kesatuan Bangsa dan Politik", "1", "admin.bkbp"],
        ];

        foreach ($skpds as $i => $skpd) {
            $newSkpd = SKPD::create([
                'kode' => $skpd[0],
                'nama_skpd' => $skpd[1],
                'foto_skpd' => 'default.jpg', // Ubah jika ada path foto tersedia
                'level_otoritas' => $skpd[2], // Atur level otoritas sesuai kebutuhan
            ]);

                // Buat akun admin baru
                $adminUser = User::create([
                    'name' => 'Admin ' . $skpd[1],
                    'id_skpd' => $newSkpd->id,
                    'level_user' => 1, // Level user untuk admin
                    'username' => $skpd[3],
                    'email' => $skpd[3].'@segeraberkinerja.com',
                    'password' => Hash::make('password'), // Ganti 'password' dengan password yang diinginkan
                    'no_hp' => '081234567890', // Nomor HP admin
                    'profile_pict' => 'default.jpg', // Path foto profil default atau yang diinginkan
                ]);
        }
    }
}
