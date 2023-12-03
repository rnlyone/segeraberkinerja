<?php

namespace App\Http\Controllers;

use App\Models\ItemKegiatan;
use App\Models\Kegiatan;
use App\Models\Program;
use App\Models\Renstra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\InputBag;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $customcss = '';
        $tahun = $request->query('tahun');
        $idp = $request->query('program');
        // $jmlsetting = Setting::where('group', 'env')->get();
        $settings = ['customcss' => $customcss,
                     'title' => 'Tambah Kegiatan',
                     'baractive' => 'programbar',
                    ];
                    // foreach ($jmlsetting as $i => $set) {
                    //     $settings[$set->setname] = $set->value;
                    //  }

        $program = Program::find($idp);

        return view('kegiatan.add', [
            $settings['baractive'] => 'active',
            'tahun' => $tahun,
            'renstra' => $program->renstra,
            'program' => $program,
            'stgs' => $settings,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $skpd = auth()->user()->skpd;


        // Validasi request sesuai kebutuhan
        $validatedData = $request->validate([
            'kode' => 'required|string',
            'nama_kegiatan' => 'required|string',
            // Tambahkan validasi untuk kolom lainnya sesuai kebutuhan
        ]);

        try {
            // Buat instance baru dari model Program
            $kegiatan = new Kegiatan();

            // Set nilai atribut sesuai dengan data yang divalidasi dari request

            $kegiatan->id_program =  $request->id_program;
            $kegiatan->tahun = $request->tahun;
            $kegiatan->kode = $validatedData['kode'];
            $kegiatan->nama_kegiatan = $validatedData['nama_kegiatan'];
            // Set atribut lainnya sesuai kebutuhan

            // Simpan data ke dalam database
            $kegiatan->save();

            return redirect()->route('program.show', ['program' => $request->id_program])->with('success', 'Program berhasil ditambahkan');
        } catch (\Exception $e) {
            // Tangani jika terjadi error saat menyimpan data
            return redirect()->back()->with('error', 'Gagal menambahkan program: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function show(Kegiatan $kegiatan, Request $request)
    {
        $customcss = '';
        // $jmlsetting = Setting::where('group', 'env')->get();
        $settings = ['customcss' => $customcss,
                     'title' => 'List Sub Kegiatan',
                     'baractive' => 'programbar',
                    ];
                    // foreach ($jmlsetting as $i => $set) {
                    //     $settings[$set->setname] = $set->value;
                    //  }

        $itemKegiatans = $kegiatan->itemKegiatans;

        if ($request->ajax()){
            return DataTables::of($itemKegiatans)
            ->addColumn('action', function($data){
                $button = '';
                if ($data->pagu_indikatif > 0){
                    $button .= '
                    <a href="'.route('item_kegiatan.show', ['item_kegiatan' => $data->id]).'" class="delete btn btn-icon btn-outline-info">
                        <i data-feather="eye"></i>
                    </a>';
                }
                // $button .= '&nbsp;&nbsp;';
                $button .= '
                <form action="'.route('item_kegiatan.destroy', ['item_kegiatan' => $data->id]).'" method="POST" class="delete-form">
                    '.csrf_field().'
                    '.method_field('DELETE').'

                    <button type="submit" class="delete btn btn-icon btn-outline-danger" onclick="return confirm(\'Apakah Anda yakin ingin menghapus itemKegiatans ini?\')">
                        <i data-feather="trash-2"></i>
                    </button>
                </form>';
                return $button;
            })
            ->editColumn('nama_sub', function($data){
                return Str::of($data->nama_sub)->limit(150, '...');
            })
            ->editColumn('kode', function($data){
                $kode = $data->kegiatan->program->renstra->skpd->kode;
                $kode_parts = explode('.', $kode);

                // Ambil dua elemen pertama setelah pemecahan string berdasarkan titik
                $result = implode('.', array_slice($kode_parts, 0, 2));

                return $result.'.'.$data->kegiatan->program->kode.'.'.$data->kegiatan->kode.'.'.$data->kode;
            })
            ->editColumn('pagu_anggaran', function($data){
                if ($data->pagu_anggaran > 0){
                    return "Rp. ". number_format($data->pagu_anggaran, 0, ',', '.');
                }else {
                    return '<span class="badge rounded-pill bg-warning">Belum ada</span>';
                }
            })
            ->editColumn('pagu_indikatif', function($data){
                if ($data->pagu_indikatif > 0){
                    return "Rp. ". number_format($data->pagu_indikatif, 0, ',', '.');
                }else {
                    return '<span class="badge rounded-pill bg-warning">Rp. Belum Ada</span>';
                }
            })
            ->rawColumns(['action', 'pagu_indikatif', 'pagu_anggaran'])
            ->addIndexColumn()
            ->make(true);
        }

        // dd($programs);

        return view('kegiatan.show', [
            $settings['baractive'] => 'active',
            'kegiatan' => $kegiatan,
            'program' => $kegiatan->program,
            'stgs' => $settings,
        ]);
    }


    public function update_pagu(Request $request){
        $allParameters = $request->all();

        // Memisahkan atribut-atribut dengan kunci yang dimulai dengan angka
        $numericAttributes = [];
        $otherAttributes = [];

        foreach ($allParameters as $key => $value) {
            if (is_numeric(substr($key, 0, 1))) {
                $numericAttributes[$key] = $value;
            } else {
                $otherAttributes[$key] = $value;
            }
        }
        // dd($numericAttributes);

        foreach ($numericAttributes as $key => $value) {
            $index = strtok($key, '_'); // Mengambil bagian index dari kunci
            $property = substr($key, strpos($key, '_') + 1); // Mengambil sisa kunci setelah index

            if (!isset($result[$index])) {
                $result[$index] = []; // Inisialisasi array jika belum ada
            }

            $result[$index][$property] = $value; // Memasukkan nilai ke dalam objek dengan index yang sesuai
        }
        // dd($result);

        foreach($result as $i => $val){
            $item = ItemKegiatan::find($i);
            $item->pagu_indikatif = $val['pagu_indikatif'];
            $item->save();
        }

        #update pagu indikatif kegiatan
        $kegiatan = $item->kegiatan;
        $pagu_indikatif = 0;
        foreach($kegiatan->itemKegiatans as $item){
            $pagu_indikatif += $item->pagu_indikatif;
        }

        $kegiatan->pagu_indikatif = $pagu_indikatif;
        $kegiatan->save();

        return back()->with('success', 'Berhasil Mengedit Pagu Indikatif');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function edit(Kegiatan $kegiatan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kegiatan $kegiatan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kegiatan $kegiatan)
    {
        $kegiatan->delete();

        return redirect()->back()->with('success', 'Kegiatan Berhasil dihapus');
    }
}
