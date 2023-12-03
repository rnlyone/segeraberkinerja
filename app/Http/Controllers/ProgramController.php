<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Renstra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $skpd = auth()->user()->skpd;
            $latestrenstra = $skpd->renstras()->latest()->first()->id;
            return redirect()->route('renstra.show', ['renstra' => $latestrenstra]);
        } catch (\Throwable $th) {
            return redirect()->route('renstra.index')->with('error', 'Tambahkan Minimal 1 Rencana Strategis');
        }

        // $customcss = '';
        // // $jmlsetting = Setting::where('group', 'env')->get();
        // $settings = ['customcss' => $customcss,
        //              'title' => 'program',
        //              'baractive' => 'programbar',
        //             ];
        //             // foreach ($jmlsetting as $i => $set) {
        //             //     $settings[$set->setname] = $set->value;
        //             //  }

        // // $renstradata = Renstra::where('id_skpd', Auth::user()->skpd->id)->orderBy('periode', 'desc')->get();

        // // if ($request->ajax()){
        // //     return DataTables::of($renstradata)
        // //     ->addColumn('action', function($data){
        // //         $button = '
        // //         <a href="'.route('renstra.show', ['renstra' => $data->id]).'" class="edit-post btn btn-icon btn-success">
        // //             <i data-feather="eye"></i>
        // //         </a>';
        // //         return $button;
        // //     })
        // //     ->editColumn('periode', function($data){
        // //         return $data->periode . '-' . ($data->periode + 5);
        // //     })
        // //     ->rawColumns(['action'])
        // //     ->addIndexColumn()
        // //     ->make(true);
        // // }

        // return view('program.index', [
        //     $settings['baractive'] => 'active',
        //     'stgs' => $settings,
        // ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customcss = '';
        // $jmlsetting = Setting::where('group', 'env')->get();
        $settings = ['customcss' => $customcss,
                     'title' => 'Edit Program',
                     'baractive' => 'programbar',
                    ];
                    // foreach ($jmlsetting as $i => $set) {
                    //     $settings[$set->setname] = $set->value;
                    //  }

        $skpd = auth()->user()->skpd;
        $renstra = $skpd->renstras()->latest()->first();

        return view('program.add', [
            $settings['baractive'] => 'active',
            'renstra' => $renstra,
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
        $skpd = auth()->user()->skpd;
        $latestrenstra = $skpd->renstras()->latest()->first();

        // Validasi request sesuai kebutuhan
        $validatedData = $request->validate([
            'kode' => 'required|string',
            'nama_program' => 'required|string',
            'jenis_program' => 'required|in:rutin,kerja',
            // Tambahkan validasi untuk kolom lainnya sesuai kebutuhan
        ]);

        try {
            // Buat instance baru dari model Program
            $program = new Program();

            // Set nilai atribut sesuai dengan data yang divalidasi dari request

            $program->id_renstra =  $latestrenstra->id;
            $program->kode = $validatedData['kode'];
            $program->nama_program = $validatedData['nama_program'];
            $program->jenis_program = $validatedData['jenis_program'];
            $program->dokumen = $validatedData['nama_program'].'.pdf';
            // Set atribut lainnya sesuai kebutuhan

            // Simpan data ke dalam database
            $program->save();

            return redirect()->route('renstra.show', ['renstra' => $latestrenstra])->with('success', 'Program berhasil ditambahkan');
        } catch (\Exception $e) {
            // Tangani jika terjadi error saat menyimpan data
            return redirect()->back()->with('error', 'Gagal menambahkan program: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function show(Program $program)
    {
        $customcss = '';
        // $jmlsetting = Setting::where('group', 'env')->get();
        $settings = ['customcss' => $customcss,
                     'title' => 'Kegiatan Program',
                     'baractive' => 'programbar',
                    ];
                    // foreach ($jmlsetting as $i => $set) {
                    //     $settings[$set->setname] = $set->value;
                    //  }

        $kegiatans = $program->kegiatans;


        // dd($programs);

        return view('program.show', [
            $settings['baractive'] => 'active',
            'program' => $program,
            'kegiatans' => $kegiatans,
            'stgs' => $settings,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function get_table(Program $program, Request $request, $tahun){
        $kegiatanpt = $program->kegiatans->where('tahun', $tahun);

        if ($request->ajax()){
            return DataTables::of($kegiatanpt)
            ->addColumn('action', function($data){
                $button = '
                <a href="'.route('kegiatan.show', ['kegiatan' => $data->id]).'" class="delete btn btn-icon btn-outline-info">
                    <i data-feather="eye"></i>
                </a>';
                // $button .= '&nbsp;&nbsp;';
                $button .= '
                <form action="'.route('kegiatan.destroy', ['kegiatan' => $data->id]).'" method="POST" class="delete-form">
                    '.csrf_field().'
                    '.method_field('DELETE').'

                    <button type="submit" class="delete btn btn-icon btn-outline-danger" onclick="return confirm(\'Apakah Anda yakin ingin menghapus kegiatan ini?\')">
                        <i data-feather="trash-2"></i>
                    </button>
                </form>';
                return $button;
            })
            ->editColumn('nama_kegiatan', function($data){
                return Str::of($data->nama_kegiatan)->limit(150, '...');
            })
            ->editColumn('kode', function($data){
                $kode = $data->program->renstra->skpd->kode;
                $kode_parts = explode('.', $kode);

                // Ambil dua elemen pertama setelah pemecahan string berdasarkan titik
                $result = implode('.', array_slice($kode_parts, 0, 2));

                return $result.'.'.$data->program->kode.'.'.$data->kode;
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function get_data(Program $program){
        //return response
        return response()->json([
            'success' => true,
            'message' => 'Detail Program',
            'data'    => $program
        ]);
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function edit(Program $program)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Program $program)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function destroy(Program $program)
    {
        $program->delete();

        return back()->with('success', 'Berhasil Menghapus Program');
    }
}
