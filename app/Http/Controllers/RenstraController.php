<?php

namespace App\Http\Controllers;

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
                $button = '
                <a href="'.route('renstra.edit', ['renstra'. $data->id]).'" class="edit-post btn btn-icon btn-success">
                    <i data-feather="edit-3"></i>
                </a>';
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
