<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Program;
use App\Models\SKPD;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class SKPDController extends Controller
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
                     'title' => 'SKPD',
                     'baractive' => 'penganggaranbar',
                    ];
                    // foreach ($jmlsetting as $i => $set) {
                    //     $settings[$set->setname] = $set->value;
                    //  }
        $skpd = SKPD::all();

        if ($request->ajax()){
            return DataTables::of($skpd)
            ->addColumn('action', function($data){
                $button = '';
                $button .= '
                <a href="'.route('skpd.show', ['skpd' => $data->id]).'" class="delete btn btn-icon btn-outline-info">
                    <i data-feather="eye"></i>
                </a>';
                // $button .= '&nbsp;&nbsp;';
                $button .= '
                <form action="'.route('skpd.destroy', ['skpd' => $data->id]).'" method="POST" class="delete-form">
                    '.csrf_field().'
                    '.method_field('DELETE').'

                    <button type="submit" class="delete btn btn-icon btn-outline-danger" onclick="return confirm(\'Apakah Anda yakin ingin menghapus kegiatan ini?\')">
                        <i data-feather="trash-2"></i>
                    </button>
                </form>';
                return $button;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }

        return view('skpd.index', [
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SKPD  $skpd
     * @return \Illuminate\Http\Response
     */
    public function show(SKPD $skpd, Request $request)
    {

        try {
            // dd($skpd);
            $renstra = $skpd->renstras()->latest()->first();
            $customcss = '';
            // $jmlsetting = Setting::where('group', 'env')->get();
            $settings = ['customcss' => $customcss,
                        'title' => 'Program SPKD',
                        'baractive' => 'penganggaranbar',
                        ];
                        // foreach ($jmlsetting as $i => $set) {
                        //     $settings[$set->setname] = $set->value;
                        //  }

            $programs = $renstra->programs;

            if ($request->ajax()){
                return DataTables::of($programs)
                ->addColumn('action', function($data){
                    $button = '';
                    $button .= '
                    <a type="button"
                            class="btn btn-outline-primary"
                            href="'.route('penganggaran.program.show', ['program' => $data->id]).'"
                            class="delete btn btn-icon btn-outline-success"
                            data-id="'.$data->id.'">
                        <i data-feather="eye"></i>
                    </a>
                    ';
                    return $button;
                })
                ->editColumn('nama_kegiatan', function($data){
                    return Str::of($data->nama_kegiatan)->limit(150, '...');
                })

                ->editColumn('kode', function($data){
                    $kode = $data->renstra->skpd->kode;
                    $kode_parts = explode('.', $kode);

                    // Ambil dua elemen pertama setelah pemecahan string berdasarkan titik
                    $result = implode('.', array_slice($kode_parts, 0, 2));

                    return $result.'.'.$data->kode;
                })
                ->editColumn('output', function($data){
                    return Str::of($data->output)->limit(150, '...');
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

            return view('renstra.show', [
                $settings['baractive'] => 'active',
                'renstra' => $renstra,
                'programs' => $programs,
                'stgs' => $settings,
            ]);
        } catch (\Throwable $th) {
            // dd($th);
            return redirect()->route('skpd.index')->with('failed', 'SKPD tidak memiliki Minimal 1 Rencana Strategis');
        }
    }

        /**
     * Display the specified resource.
     *
     * @param  \App\Models\Program  $skpd
     * @return \Illuminate\Http\Response
     */
    public function programshow(Program $program, Request $request)
    {
        $customcss = '';
        // $jmlsetting = Setting::where('group', 'env')->get();
        $settings = ['customcss' => $customcss,
                     'title' => 'Kegiatan Program',
                     'baractive' => 'penganggaranbar',
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
     * @param  \App\Models\Program  $skpd
     * @return \Illuminate\Http\Response
     */
    public function get_table(Program $program, Request $request, $tahun){
        $kegiatanpt = $program->kegiatans->where('tahun', $tahun);

        if ($request->ajax()){
            return DataTables::of($kegiatanpt)
            ->addColumn('action', function($data){
                $button = '';
                    $button .= '
                    <button type="button"
                            class="btn btn-outline-primary btn-edit-kegiatan"
                            data-bs-toggle="modal"
                            data-bs-target="#detailprogram"
                            data-id="'.$data->id.'">
                        <i data-feather="eye"></i>
                    </button>
                    ';
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

                return $result.'.'.$data->kode;
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
     * @param  \App\Models\Kegiatan  $program
     * @return \Illuminate\Http\Response
     */
    public function get_data(Kegiatan $kegiatan){
        //return response
        return response()->json([
            'success' => true,
            'message' => 'Detail Program',
            'data'    => $kegiatan,
            'items'    => $kegiatan->itemKegiatans,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SKPD  $skpd
     * @return \Illuminate\Http\Response
     */
    public function edit(SKPD $skpd)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SKPD  $skpd
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SKPD $skpd)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SKPD  $skpd
     * @return \Illuminate\Http\Response
     */
    public function destroy(SKPD $skpd)
    {
        //
    }
}
