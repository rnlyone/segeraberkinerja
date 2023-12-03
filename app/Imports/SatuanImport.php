<?php

namespace App\Imports;

use App\Models\Kelompok;
use App\Models\Satuan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SatuanImport implements ToModel, WithStartRow
{
    private $jenis_satuan;

    public function __construct($jenis_satuan)
    {
        $this->jenis_satuan = $jenis_satuan;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Cek apakah kelompok sudah ada
        $kelompok = Kelompok::where('kode', $row[0])->first();

        if (!$kelompok) {
            // Jika kelompok tidak ada, buat baru
            $kelompok = Kelompok::create([
                'kode' => $row[0],
                'uraian' => $row[1],
                'jenis_satuan' => $this->jenis_satuan
            ]);
        }

        $kode_parts = explode('.', $row[3]);

        // Ambil elemen terakhir dari array
        $last_part = end($kode_parts);

        // Hapus nol di depan string
        $last_part_trimmed = ltrim($last_part, '0');

        // Buat model satuan
        return new Satuan([
            'id_kelompok' => $kelompok->id,
            'jenis_satuan' => $this->jenis_satuan,
            'kode' => $last_part_trimmed,
            'nama_item' => $row[4],
            'spesifikasi' => $row[5],
            'satuan' => $row[6],
            'harga' => $row[7],
            'kode_rekening' => $row[8],
        ]);
    }

     /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }
}
