<?php

namespace App\Http\Controllers;

use App\Imports\SatuanImport;
use App\Models\Kelompok;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $jenis_satuan = $request->query('satuan');

        $customcss = '';
        // $jmlsetting = Setting::where('group', 'env')->get();
        $settings = ['customcss' => $customcss,
                     'title' => $jenis_satuan,
                     'baractive' => $jenis_satuan.'bar',
                    ];
                    // foreach ($jmlsetting as $i => $set) {
                    //     $settings[$set->setname] = $set->value;
                    //  }

        $satuandata = Satuan::where('jenis_satuan', $jenis_satuan)->get();
        // dd($satuandata);

        if ($request->ajax()){
            return DataTables::of($satuandata)
            ->addColumn('action', function($data){
                $button = '
                <a href="'.route('satuan.edit', ['satuan'. $data->id]).'" class="edit-post btn btn-icon btn-success">
                    <i data-feather="edit-3"></i>
                </a>';
                // $button .= '&nbsp;&nbsp;';
                $button .= '
                <form action="'.route('satuan.destroy', ['satuan' => $data->id]).'" method="POST" class="delete-form">
                    '.csrf_field().'
                    '.method_field('DELETE').'

                    <button type="submit" class="delete btn btn-icon btn-outline-danger" onclick="return confirm(\'Apakah Anda yakin ingin menghapus kegiatan ini?\')">
                        <i data-feather="trash-2"></i>
                    </button>
                </form>';
                return $button;
            })
            ->editColumn('id_kelompok', function($data){
                return $data->kelompok->uraian;
            })
            ->editColumn('harga', function($data){
                if ($data->harga > 0){
                    return "Rp. ". number_format($data->harga, 0, ',', '.');
                }else {
                    return '<span class="badge rounded-pill bg-warning">Belum ada Harga</span>';
                }
            })
            ->rawColumns(['action', 'harga', 'id_kelompok'])
            ->addIndexColumn()
            ->make(true);
        }



        return view('ssh.index', [
            $settings['baractive'] => 'active',
            'anujenissatuan' => $jenis_satuan,
            'stgs' => $settings,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function get_data(Satuan $satuan)
    {
        return response()->json([
            'success' => true,
            'message' => 'Satuan Get',
            'data'    => $satuan,
            'kelompok' => $satuan->kelompok
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $jenis_satuan = $request->query('jenis_satuan');

        $customcss = '';
        // $jmlsetting = Setting::where('group', 'env')->get();
        $settings = ['customcss' => $customcss,
                     'title' => 'Tambah Satuan',
                     'baractive' => $jenis_satuan.'bar',
                    ];
                    // foreach ($jmlsetting as $i => $set) {
                    //     $settings[$set->setname] = $set->value;
                    //  }

        $kelompoks = Kelompok::all();

        return view('ssh.add', [
            $settings['baractive'] => 'active',
            'anujenissatuan' => $jenis_satuan,
            'kelompoks' => $kelompoks,
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
        // dd($request);

        return redirect()->back()->with('success', 'Satuan Berhasil di Tambahkan.');
    }

    public function importSatuan(Request $request)
    {
        // dd($request);
        $jenis_satuan = $request->jenis_satuan;

        if ($request->hasFile('excel_file')) {
            $file = $request->file('excel_file');

            // Pastikan file adalah file Excel
            if ($file->getClientOriginalExtension() === 'xlsx' || $file->getClientOriginalExtension() === 'xls') {
                Excel::import(new SatuanImport($jenis_satuan), $file);

                return redirect()->back()->with('success', 'Import data berhasil.');
            } else {
                return redirect()->back()->with('failed', 'File harus berformat Excel (xlsx/xls).');
            }
        } else {
            return redirect()->back()->with('failed', 'Pilih file untuk diupload.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function show(Satuan $satuan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function edit(Satuan $satuan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Satuan $satuan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function destroy($jenis_satuan)
    {
        Satuan::where('jenis_satuan', $jenis_satuan)->delete();

        return redirect()->route('satuan.index', ['satuan' => $jenis_satuan])->with('success', 'Semua Satuan Berhasil di Hapus');
    }
}
