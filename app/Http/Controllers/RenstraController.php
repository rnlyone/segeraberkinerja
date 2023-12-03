<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Renstra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class RenstraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customcss = '';
        // $jmlsetting = Setting::where('group', 'env')->get();
        $settings = ['customcss' => $customcss,
                     'title' => 'Renstra',
                     'baractive' => 'renstrabar',
                    ];
                    // foreach ($jmlsetting as $i => $set) {
                    //     $settings[$set->setname] = $set->value;
                    //  }

        $renstradata = Renstra::where('id_skpd', Auth::user()->skpd->id)->orderBy('periode', 'desc')->get();

        if ($request->ajax()){
            return DataTables::of($renstradata)
            ->addColumn('action', function($data){
                // $button = '
                // <a href="'.route('renstra.edit', ['renstra'. $data->id]).'" class="edit-post btn btn-icon btn-success">
                //     <i data-feather="edit-3"></i>
                // </a>';
                $button = '
                <button class="edit-post btn btn-icon btn-success">
                    <i data-feather="edit-3"></i>
                </button>';
                // $button .= '&nbsp;&nbsp;';
                $button .= '
                <form action="'.route('renstra.destroy', ['renstra' => $data->id]).'" method="POST" class="delete-form">
                    '.csrf_field().'
                    '.method_field('DELETE').'

                    <button type="submit" class="delete btn btn-icon btn-outline-danger" onclick="return confirm(\'Apakah Anda yakin ingin menghapus kegiatan ini?\')">
                        <i data-feather="trash-2"></i>
                    </button>
                </form>';
                return $button;
            })
            ->editColumn('periode', function($data){
                return $data->periode . '-' . ($data->periode + 5);
            })
            ->editColumn('visi', function($data){
                return strip_tags(Str::of($data->visi)->limit(150, '...'));
            })
            ->editColumn('misi', function($data){
                return strip_tags(Str::of($data->misi)->limit(150, '...'));
            })
            ->editColumn('tujuan', function($data){
                return strip_tags(Str::of($data->tujuan)->limit(150, '...'));
            })
            ->editColumn('sasaran', function($data){
                return strip_tags(Str::of($data->sasaran)->limit(150, '...'));
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }



        return view('renstra.index', [
            $settings['baractive'] => 'active',
            'stgs' => $settings,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customcss = '

        ';
        // $jmlsetting = Setting::where('group', 'env')->get();
        $settings = ['customcss' => $customcss,
                     'title' => 'Renstra',
                     'baractive' => 'renstrabar',
                    ];
                    // foreach ($jmlsetting as $i => $set) {
                    //     $settings[$set->setname] = $set->value;
                    //  }


        return view('renstra.add', [
            $settings['baractive'] => 'active',
            'stgs' => $settings,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi data yang dikirimkan
        $validatedData = $request->validate([
            // Atur aturan validasi sesuai kebutuhan Anda
            'periode' => 'required',
            'visi' => 'required',
            'misi' => 'required',
            'tujuan' => 'required',
            'sasaran' => 'required',
        ]);

        // Buat instansiasi objek Renstra dengan data yang dikirimkan dari form
        $renstra = new Renstra();
        $renstra->id_skpd = auth()->user()->id_skpd;
        $renstra->periode = $validatedData['periode'];
        $renstra->visi = $validatedData['visi'];
        $renstra->misi = $validatedData['misi'];
        $renstra->tujuan = $validatedData['tujuan'];
        $renstra->sasaran = $validatedData['sasaran'];
        $renstra->dokumen = $validatedData['periode'].'pdf';
        // ...

        // Simpan data ke dalam database
        $renstra->save();

        $data = [
            [
                'program' => [
                    'kode' => '01',
                    'nama' => 'PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN/KOTA',
                    'jenis_program' => 'rutin',
                    'kegiatan' => [
                        [
                            'kode' => '201',
                            'nama' => 'Perencanaan, Penganggaran, dan Evaluasi Kinerja Perangkat Daerah',
                            'sub_kegiatan' => [
                                ['satuan' => 'Dokumen','kode' => '01', 'nama' => 'Penyusunan Dokumen Perencanaan Perangkat Daerah'],
                                ['satuan' => 'Dokumen','kode' => '02', 'nama' => 'Koordinasi dan Penyusunan Dokumen RKA-SKPD'],
                                ['satuan' => 'Dokumen','kode' => '03', 'nama' => 'Koordinasi dan Penyusunan Dokumen Perubahan RKA-SKPD'],
                                ['satuan' => 'Dokumen','kode' => '04', 'nama' => 'Koordinasi dan Penyusunan DPA-SKPD'],
                                ['satuan' => 'Dokumen','kode' => '05', 'nama' => 'Koordinasi dan Penyusunan Perubahan DPA-SKPD'],
                                ['satuan' => 'Laporan','kode' => '06', 'nama' => 'Koordinasi dan Penyusunan Laporan Capaian Kinerja dan Ikhtisar Realisasi Kinerja SKPD'],
                                ['satuan' => 'Laporan','kode' => '07', 'nama' => 'Evaluasi Kinerja Perangkat Daerah'],
                            ],
                        ],
                        [
                            'kode' => '202',
                            'nama' => 'Administrasi Keuangan Perangkat Daerah',
                            'sub_kegiatan' => [
                                ['satuan' => 'Orang/bulan','kode' => '01', 'nama' => 'Penyediaan Gaji dan Tunjangan ASN'],
                                ['satuan' => 'Dokumen','kode' => '02', 'nama' => 'Penyediaan Administrasi Pelaksanaan Tugas ASN'],
                                ['satuan' => 'Dokumen','kode' => '03', 'nama' => 'Pelaksanaan Penatausahaan dan Pengujian/Verifikasi Keuangan SKPD'],
                                ['satuan' => 'Dokumen','kode' => '04', 'nama' => 'Koordinasi dan Pelaksanaan Akuntansi SKPD'],
                                ['satuan' => 'Laporan','kode' => '05', 'nama' => 'Koordinasi dan Penyusunan Laporan Keuangan Akhir Tahun SKPD'],
                                ['satuan' => 'Dokumen','kode' => '06', 'nama' => 'Pengelolaan dan Penyiapan Bahan Tanggapan Pemeriksaan'],
                                ['satuan' => 'Laporan','kode' => '07', 'nama' => 'Koordinasi dan Penyusunan Laporan Keuangan Bulanan/Triwulanan/Semesteran SKPD'],
                                ['satuan' => 'Dokumen','kode' => '08', 'nama' => 'Penyusunan Pelaporan dan Analisis Prognosis Realisasi Anggaran'],
                            ],
                        ],
                        [
                            'kode' => '203',
                            'nama' => 'Administrasi Barang Milik Daerah pada Perangkat Daerah',
                            'sub_kegiatan' => [
                                ['satuan' => 'Dokumen','kode' => '01', 'nama' => 'Penyusunan Perencanaan Kebutuhan Barang Milik Daerah SKPD'],
                                ['satuan' => 'Dokumen','kode' => '02', 'nama' => 'Pengamanan Barang Milik Daerah SKPD'],
                                ['satuan' => 'Laporan','kode' => '03', 'nama' => 'Koordinasi dan Penilaian Barang Milik Daerah SKPD'],
                                ['satuan' => 'Laporan','kode' => '04', 'nama' => 'Pembinaan, Pengawasan, dan Pengendalian Barang Milik Daerah pada SKPD'],
                                ['satuan' => 'Laporan','kode' => '05', 'nama' => 'Rekonsiliasi dan Penyusunan Laporan Barang Milik Daerah pada SKPD'],
                                ['satuan' => 'Laporan','kode' => '06', 'nama' => 'Penatausahaan Barang Milik Daerah pada SKPD'],
                                ['satuan' => 'Dokumen','kode' => '07', 'nama' => 'Pemanfaatan Barang Milik Daerah SKPD'],
                            ],
                        ],
                        [
                            'kode' => '204',
                            'nama' => 'Administrasi Pendapatan Daerah Kewenangan Perangkat Daerah',
                            'sub_kegiatan' => [
                                ['satuan' => 'Dokumen','kode' => '01', 'nama' => 'Perencanaan Pengelolaan Retribusi Daerah'],
                                ['satuan' => 'Dokumen','kode' => '02', 'nama' => 'Analisa dan Pengembangan Retribusi Daerah, serta Penyusunan Kebijakan Retribusi Daerah'],
                                ['satuan' => 'Laporan','kode' => '03', 'nama' => 'Penyuluhan dan Penyebarluasan Kebijakan Retribusi Daerah'],
                                ['satuan' => 'Dokumen','kode' => '04', 'nama' => 'Pendataan dan Pendaftaran Objek Retribusi Daerah'],
                                ['satuan' => 'Laporan','kode' => '05', 'nama' => 'Pengolahan Data Retribusi Daerah'],
                                ['satuan' => 'Dokumen','kode' => '06', 'nama' => 'Penetapan Wajib Retribusi Daerah'],
                                ['satuan' => 'Dokumen','kode' => '07', 'nama' => 'Pelaporan Pengelolaan Retribusi Daerah'],
                            ],
                        ],
                        [
                            'kode' => '205',
                            'nama' => 'Administrasi Kepegawaian Perangkat Daerah',
                            'sub_kegiatan' => [
                                ['satuan' => 'Unit','kode' => '01', 'nama' => 'Peningkatan Sarana dan Prasarana Disiplin Pegawai'],
                                ['satuan' => 'Paket','kode' => '02', 'nama' => 'Pengadaan Pakaian Dinas beserta Atribut Kelengkapannya'],
                                ['satuan' => 'Dokumen','kode' => '03', 'nama' => 'Pendataan dan Pengolahan Administrasi Kepegawaian'],
                                ['satuan' => 'Dokumen','kode' => '04', 'nama' => 'Koordinasi dan Pelaksanaan Sistem Informasi Kepegawaian'],
                                ['satuan' => 'Dokumen','kode' => '05', 'nama' => 'Monitoring, Evaluasi, dan Penilaian Kinerja Pegawai'],
                                ['satuan' => 'Orang','kode' => '06', 'nama' => 'Pemulangan Pegawai yang Pensiun'],
                                ['satuan' => 'Laporan','kode' => '07', 'nama' => 'Pemulangan Pegawai yang Meninggal dalam Melaksanakan Tugas'],
                                ['satuan' => 'Orang','kode' => '08', 'nama' => 'Pemindahan Tugas ASN'],
                                ['satuan' => 'Orang','kode' => '09', 'nama' => 'Pendidikan dan Pelatihan Pegawai Berdasarkan Tugas dan Fungsi'],
                                ['satuan' => 'Orang','kode' => '10', 'nama' => 'Sosialisasi Peraturan Perundang-Undangan'],
                                ['satuan' => 'Orang','kode' => '11', 'nama' => 'Bimbingan Teknis Implementasi Peraturan Perundang-Undangan'],
                            ],
                        ],
                        [
                            'kode' => '206',
                            'nama' => 'Administrasi Umum Perangkat Daerah',
                            'sub_kegiatan' => [
                                ['satuan' => 'Paket','kode' => '01', 'nama' => 'Penyediaan Komponen Instalasi Listrik/Penerangan Bangunan Kantor'],
                                ['satuan' => 'Paket','kode' => '02', 'nama' => 'Penyediaan Peralatan dan Perlengkapan Kantor'],
                                ['satuan' => 'Paket','kode' => '03', 'nama' => 'Penyediaan Peralatan Rumah Tangga'],
                                ['satuan' => 'Paket','kode' => '04', 'nama' => 'Penyediaan Bahan Logistik Kantor'],
                                ['satuan' => 'Paket','kode' => '05', 'nama' => 'Penyediaan Barang Cetakan dan Penggandaan'],
                                ['satuan' => 'Dokumen','kode' => '06', 'nama' => 'Penyediaan Bahan Bacaan dan Peraturan Perundang-undangan'],
                                ['satuan' => 'Paket','kode' => '07', 'nama' => 'Penyediaan Bahan/Material'],
                                ['satuan' => 'Laporan','kode' => '08', 'nama' => 'Fasilitasi Kunjungan Tamu'],
                                ['satuan' => 'Laporan','kode' => '09', 'nama' => 'Penyelenggaraan Rapat Koordinasi dan Konsultasi SKPD'],
                                ['satuan' => 'Dokumen','kode' => '10', 'nama' => 'Penatausahaan Arsip Dinamis pada SKPD'],
                                ['satuan' => 'Dokumen','kode' => '11', 'nama' => 'Dukungan Pelaksanaan Sistem Pemerintahan Berbasis Elektronik pada SKPD'],
                            ],
                        ],
                        [
                            'kode' => '207',
                            'nama' => 'Pengadaan Barang Milik Daerah Penunjang Urusan Pemerintah Daerah',
                            'sub_kegiatan' => [
                                ['satuan' => 'Unit','kode' => '01', 'nama' => 'Pengadaan Kendaraan Perorangan Dinas atau Kendaraan Dinas Jabatan'],
                                ['satuan' => 'Unit','kode' => '02', 'nama' => 'Pengadaan Kendaraan Dinas Operasional atau Lapangan'],
                                ['satuan' => 'Unit','kode' => '03', 'nama' => 'Pengadaan Alat Besar'],
                                ['satuan' => 'Unit','kode' => '04', 'nama' => 'Pengadaan Alat Angkutan Darat Tak Bermotor'],
                                ['satuan' => 'Unit','kode' => '05', 'nama' => 'Pengadaan Mebel'],
                                ['satuan' => 'Unit','kode' => '06', 'nama' => 'Pengadaan Peralatan dan Mesin Lainnya'],
                                ['satuan' => 'Unit','kode' => '07', 'nama' => 'Pengadaan Aset Tetap Lainnya'],
                                ['satuan' => 'Unit','kode' => '08', 'nama' => 'Pengadaan Aset Tak Berwujud'],
                                ['satuan' => 'Unit','kode' => '09', 'nama' => 'Pengadaan Gedung Kantor atau Bangunan Lainnya'],
                                ['satuan' => 'Unit','kode' => '10', 'nama' => 'Pengadaan Sarana dan Prasarana Gedung Kantor atau Bangunan Lainnya'],
                                ['satuan' => 'Unit','kode' => '11', 'nama' => 'Pengadaan Sarana dan Prasarana Pendukung Gedung Kantor atau Bangunan Lainnya'],
                            ],
                        ],
                        [
                            'kode' => '208',
                            'nama' => 'Penyediaan Jasa Penunjang Urusan Pemerintahan Daerah',
                            'sub_kegiatan' => [
                                ['satuan' => 'Laporan','kode' => '01', 'nama' => 'Penyediaan Jasa Surat Menyurat'],
                                ['satuan' => 'Laporan','kode' => '02', 'nama' => 'Penyediaan Jasa Komunikasi, Sumber Daya Air dan Listrik'],
                                ['satuan' => 'Laporan','kode' => '03', 'nama' => 'Penyediaan Jasa Peralatan dan Perlengkapan Kantor'],
                                ['satuan' => 'Laporan','kode' => '04', 'nama' => 'Penyediaan Jasa Pelayanan Umum Kantor'],
                            ],
                        ],
                        [
                            'kode' => '209',
                            'nama' => 'Pemeliharaan Barang Milik Daerah Penunjang Urusan Pemerintahan Daerah',
                            'sub_kegiatan' => [
                                ['satuan' => 'Unit','kode' => '01', 'nama' => 'Penyediaan Jasa Pemeliharaan, Biaya Pemeliharaan, dan Pajak Kendaraan Perorangan Dinas atau Kendaraan Dinas Jabatan'],
                                ['satuan' => 'Unit','kode' => '02', 'nama' => 'Penyediaan Jasa Pemeliharaan, Biaya Pemeliharaan, Pajak dan Perizinan Kendaraan Dinas Operasional atau Lapangan'],
                                ['satuan' => 'Unit','kode' => '03', 'nama' => 'Penyediaan Jasa Pemeliharaan, Biaya Pemeliharaan dan Perizinan Alat Besar'],
                                ['satuan' => 'Unit','kode' => '04', 'nama' => 'Penyediaan Jasa Pemeliharaan, Biaya Pemeliharaan dan Perizinan Alat Angkutan Darat Tak Bermotor'],
                                ['satuan' => 'Unit','kode' => '05', 'nama' => 'Pemeliharaan Mebel'],
                                ['satuan' => 'Unit','kode' => '06', 'nama' => 'Pemeliharaan Peralatan dan Mesin Lainnya'],
                                ['satuan' => 'Unit','kode' => '07', 'nama' => 'Pemeliharaan Aset Tetap Lainnya'],
                                ['satuan' => 'Unit','kode' => '08', 'nama' => 'Pemeliharaan Aset Tak Berwujud'],
                                ['satuan' => 'Unit','kode' => '09', 'nama' => 'Pemeliharaan/Rehabilitasi Gedung Kantor dan Bangunan Lainnya'],
                                ['satuan' => 'Unit','kode' => '10', 'nama' => 'Pemeliharaan/Rehabilitasi Sarana dan Prasarana Gedung Kantor atau Bangunan Lainnya'],
                                ['satuan' => 'Unit','kode' => '11', 'nama' => 'Pemeliharaan/Rehabilitasi Sarana dan Prasarana Pendukung Gedung Kantor atau Bangunan Lainnya'],
                                ['satuan' => 'Ha','kode' => '12', 'nama' => 'Pemeliharaan/Rehabilitasi Tanah'],
                            ],
                        ],
                        [
                            'kode' => '210',
                            'nama' => 'Peningkatan Pelayanan BLUD',
                            'sub_kegiatan' => [
                                ['satuan' => 'Unit Kerja','kode' => '01', 'nama' => 'Pelayanan dan Penunjang Pelayanan BLUD'],
                            ],
                        ],
                        [
                            'kode' => '211',
                            'nama' => 'Administrasi Keuangan dan Operasional Kepala Daerah dan Wakil Kepala Daerah',
                            'sub_kegiatan' => [
                                ['satuan' => 'Orang/bulan','kode' => '01', 'nama' => 'Penyediaan Gaji dan Tunjangan Kepala Daerah dan Wakil Kepala Daerah'],
                                ['satuan' => 'Paket','kode' => '02', 'nama' => 'Penyediaan Pakaian Dinas dan Atribut Kelengkapan Kepala Daerah dan Wakil Kepala Daerah'],
                                ['satuan' => 'Orang','kode' => '03', 'nama' => 'Pelaksanaan Medical Check Up Kepala Daerah dan Wakil Kepala Daerah'],
                                ['satuan' => 'Orang/bulan','kode' => '04', 'nama' => 'Penyediaan Dana Penunjang Operasional Kepala Daerah dan Wakil Kepala Daerah'],
                            ],
                        ],
                        [
                            'kode' => '212',
                            'nama' => 'Fasilitasi Kerumahtanggaan Sekretariat Daerah',
                            'sub_kegiatan' => [
                                ['satuan' => 'Paket','kode' => '01', 'nama' => 'Penyediaan Kebutuhan Rumah Tangga Kepala Daerah'],
                                ['satuan' => 'Paket','kode' => '02', 'nama' => 'Penyediaan Kebutuhan Rumah Tangga Wakil Kepala Daerah'],
                                ['satuan' => 'Paket','kode' => '03', 'nama' => 'Penyediaan Kebutuhan Rumah Tangga Sekretariat Daerah'],
                            ],
                        ],
                        [
                            'kode' => '213',
                            'nama' => 'Penataan Organisasi',
                            'sub_kegiatan' => [
                                ['satuan' => 'Dokumen','kode' => '01', 'nama' => 'Pengelolaan Kelembagaan dan Analisis Jabatan'],
                                ['satuan' => 'Laporan','kode' => '02', 'nama' => 'Fasilitasi Pelayanan Publik dan Tata Laksana'],
                                ['satuan' => 'Dokumen','kode' => '03', 'nama' => 'Peningkatan Kinerja dan Reformasi Birokrasi'],
                                ['satuan' => 'Dokumen','kode' => '04', 'nama' => 'Monitoring, Evaluasi dan Pengendalian Kualitas Pelayanan Publik dan Tata Laksana'],
                                ['satuan' => 'Dokumen','kode' => '05', 'nama' => 'Koordinasi dan Penyusunan Laporan Kinerja Pemerintah Daerah'],
                            ],
                        ],
                        [
                            'kode' => '214',
                            'nama' => 'Pelaksanaan Protokol dan Komunikasi Pimpinan',
                            'sub_kegiatan' => [
                                ['satuan' => 'Laporan','kode' => '01', 'nama' => 'Fasilitasi Keprotokolan'],
                                ['satuan' => 'Laporan','kode' => '02', 'nama' => 'Fasilitasi Komunikasi Pimpinan'],
                                ['satuan' => 'Laporan','kode' => '03', 'nama' => 'Pendokumentasian Tugas Pimpinan'],
                            ],
                        ],
                        [
                            'kode' => '215',
                            'nama' => 'Layanan Keuangan dan Kesejahteraan DPRD',
                            'sub_kegiatan' => [
                                ['satuan' => 'Orang/bulan','kode' => '01', 'nama' => 'Penyelenggaraan Administrasi Keuangan DPRD'],
                                ['satuan' => 'Paket','kode' => '02', 'nama' => 'Penyediaan Pakaian Dinas dan Atribut DPRD'],
                                ['satuan' => 'Orang','kode' => '03', 'nama' => 'Pelaksanaan Medical Check Up DPRD'],
                            ],
                        ],
                        [
                            'kode' => '216',
                            'nama' => 'Layanan Administrasi DPRD',
                            'sub_kegiatan' => [
                                ['satuan' => 'Dokumen','kode' => '01', 'nama' => 'Penyelenggaraan Administrasi Keanggotan DPRD'],
                                ['satuan' => 'Laporan','kode' => '02', 'nama' => 'Fasilitasi Fraksi DPRD'],
                                ['satuan' => 'Laporan','kode' => '03', 'nama' => 'Fasilitasi Rapat Koordinasi dan Konsultasi DPRD'],
                                ['satuan' => 'Paket','kode' => '04', 'nama' => 'Penyediaan Kebutuhan Rumah Tangga DPRD'],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($data as $programData) {
            $program = $renstra->programs()->create([
                'kode' => $programData['program']['kode'],
                'nama_program' => $programData['program']['nama'],
                'dokumen' => $programData['program']['nama'].'.pdf',
            ]);

            foreach ($programData['program']['kegiatan'] as $kegiatanData) {
                for ($i=$renstra->periode; $i <= $renstra->periode+5; $i++) {
                    $kegiatan = $program->kegiatans()->create([
                        'tahun' => $i,
                        'kode' => $kegiatanData['kode'],
                        'nama_kegiatan' => $kegiatanData['nama'],
                    ]);

                    foreach ($kegiatanData['sub_kegiatan'] as $subKegiatanData) {
                        $kegiatan->itemKegiatans()->create([
                            'kode' => $subKegiatanData['kode'],
                            'nama_sub' => $subKegiatanData['nama'],
                            'satuan' => $subKegiatanData['satuan'],
                        ]);
                    }
                }
            }
        }


        // Redirect atau berikan respons sesuai kebutuhan aplikasi Anda
        return redirect()->route('renstra.index')->with('success', 'Berhasil Menambahkan Renstra');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Renstra  $renstra
     * @return \Illuminate\Http\Response
     */
    public function show(Renstra $renstra, Request $request)
    {
        $customcss = '';
        // $jmlsetting = Setting::where('group', 'env')->get();
        $settings = ['customcss' => $customcss,
                     'title' => 'Program Renstra',
                     'baractive' => 'programbar',
                    ];
                    // foreach ($jmlsetting as $i => $set) {
                    //     $settings[$set->setname] = $set->value;
                    //  }

        $programs = $renstra->programs;

        if ($request->ajax()){
            return DataTables::of($programs)
            ->addColumn('action', function($data){
                $button = '';
                // if ($data->pagu_indikatif > 0){
                    $button .= '
                    <a href="'.route('program.show', ['program' => $data->id]).'" class="delete btn btn-icon btn-outline-info">
                        <i data-feather="eye"></i>
                    </a>';
                // }
                // $button .= '&nbsp;&nbsp;';
                $button .= '
                <form action="'.route('program.destroy', ['program' => $data->id]).'" method="POST" class="delete-form">
                    '.csrf_field().'
                    '.method_field('DELETE').'

                    <button type="submit" class="delete btn btn-icon btn-outline-danger" onclick="return confirm(\'Apakah Anda yakin ingin menghapus kegiatan ini?\')">
                        <i data-feather="trash-2"></i>
                    </button>
                </form>';
                return $button;
            })
            ->editColumn('nama_program', function($data){
                return Str::of($data->nama_program)->limit(150, '...');
            })
            ->editColumn('kode', function($data){
                $kode = $data->renstra->skpd->kode;
                $kode_parts = explode('.', $kode);

                // Ambil dua elemen pertama setelah pemecahan string berdasarkan titik
                $result = implode('.', array_slice($kode_parts, 0, 2));

                return $result.'.'.$data->kode;
            })
            ->editColumn('pagu_anggaran', function($data){
                $pagu_anggaran = 0;

                if(!empty($data->kegiatans)){
                    foreach($data->kegiatans as $kegiatan){
                        $pagu_anggaran += $kegiatan->pagu_anggaran;
                    }
                }

                if ($pagu_anggaran > 0){
                    return "Rp. ". number_format($pagu_anggaran, 0, ',', '.');
                }else {
                    return '<span class="badge rounded-pill bg-warning">Belum ada</span>';
                }
            })
            ->editColumn('pagu_indikatif', function($data){
                $pagu_indikatif = 0;

                if(!empty($data->kegiatans)){
                    foreach($data->kegiatans as $kegiatan){
                        $pagu_indikatif += $kegiatan->pagu_indikatif;
                    }
                }
                if ($pagu_indikatif > 0){
                    return "Rp. ". number_format($pagu_indikatif, 0, ',', '.');
                }else {
                    return '<span class="badge rounded-pill bg-warning">Rp. Belum Ada</span>';
                }
            })
            ->rawColumns(['action', 'pagu_indikatif', 'pagu_anggaran'])
            ->addIndexColumn()
            ->make(true);
        }

        // dd($programs);

        return view('renstra.show', [
            $settings['baractive'] => 'active',
            'renstra' => $renstra,
            'programs' => $programs,
            'stgs' => $settings,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Renstra  $renstra
     * @return \Illuminate\Http\Response
     */
    public function edit(Renstra $renstra)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Renstra  $renstra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Renstra $renstra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Renstra  $renstra
     * @return \Illuminate\Http\Response
     */
    public function destroy(Renstra $renstra)
    {
        $renstra->delete();

        return redirect()->back()->with('success', 'Berhasil Menghapus Renstra');
    }
}
