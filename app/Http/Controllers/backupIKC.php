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

class ItemKegiatanController extends Controller
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
                     'title' => 'kegiatan',
                     'baractive' => 'kegiatanbar',
                    ];
                    // foreach ($jmlsetting as $i => $set) {
                    //     $settings[$set->setname] = $set->value;
                    //  }

        $renstradata = Renstra::where('id_skpd', Auth::user()->skpd->id)->get();

        if ($request->ajax()){
            return DataTables::of($renstradata)
            ->addColumn('action', function($data){
                $button = '
                <button data-toggle="modal" data-bs-toggle="modal" data-original-title="Edit" type="button" data-bs-target="#modaledit'.$data->id.'" type="button" class="edit-post btn btn-icon btn-success">
                    <i data-feather="edit-3"></i>
                </button>';
                // $button .= '&nbsp;&nbsp;';
                $button .= '
                <form action="'.route('item_kegiatan.destroy', ['item_kegiatan' => $data->id]).'" method="POST" class="delete-form">
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
                return Str::of($data->visi)->limit(150, '...');
            })
            ->editColumn('misi', function($data){
                return Str::of($data->misi)->limit(150, '...');
            })
            ->editColumn('tujuan', function($data){
                return Str::of($data->tujuan)->limit(150, '...');
            })
            ->editColumn('sasaran', function($data){
                return Str::of($data->sasaran)->limit(150, '...');
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }

        return view('kegiatan.index', [
            $settings['baractive'] => 'active',
            'stgs' => $settings,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
// dd($request);
        $idp = $request->query('kegiatan');

        $customcss = '';
        // $jmlsetting = Setting::where('group', 'env')->get();
        $settings = ['customcss' => $customcss,
                     'title' => 'Buat Program',
                     'baractive' => 'programbar',
                    ];
                    // foreach ($jmlsetting as $i => $set) {
                    //     $settings[$set->setname] = $set->value;
                    //  }

        $kegiatan = Kegiatan::find($idp);

        // $sisa_pagu_anggaran = $kegiatan->pagu_indikatif - $kegiatan->pagu_anggaran;

        return view('itemkegiatan.add', [
            $settings['baractive'] => 'active',
            'renstra' => $kegiatan->program->renstra,
            'program' => $kegiatan->program,
            'kegiatan' => $kegiatan,
            // 'sisa_pagu_anggaran' => $sisa_pagu_anggaran,
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
        $program = Program::find($request->id_program);

        // Validasi request sesuai kebutuhan
        $validatedData = $request->validate([
            'tahun' => 'required|string',
            'nama_kegiatan' => 'required|string',
            'satuan' => 'required|string',
            'volume' => 'required|integer',
            // Tambahkan validasi untuk kolom lainnya sesuai kebutuhan
        ]);
        // Mendapatkan semua parameters dari request
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

        // dd($result[1]);


        try {
            $kegiatan = New Kegiatan();

            $kegiatan->id_program = $request->id_program;
            $kegiatan->tahun = $validatedData['tahun'];
            $kegiatan->nama_kegiatan = $validatedData['nama_kegiatan'];
            $kegiatan->satuan = $validatedData['satuan'];
            $kegiatan->volume = $validatedData['volume'];

            $kegiatan->save();

            foreach ($result as $i => $value) {
                $item = new ItemKegiatan();

                $item->id_kegiatan = $kegiatan->id;
                $item->sub_item = $value['sub_item_kegiatan'];
                $item->tipe_item = $value['tipe_item_kegiatan'];
                $item->nama_item = $value['nama_item_kegiatan'];
                $item->satuan = $value['satuan_item_kegiatan'];
                $item->harga = $value['harga_item_kegiatan'];
                $item->volume = $value['volume_item_kegiatan'];

                $item->save();

                $totalItem[$item->id] = $item->harga * $item->volume;
            }

            $grandTotal = 0;

            // Loop melalui array $totalItem untuk menjumlahkan nilai
            foreach ($totalItem as $itemTotal) {
                $grandTotal += $itemTotal;
            }

            $kegiatan->harga = $grandTotal;

            $kegiatan->save();

            $grandgrandTotal = $grandTotal * $kegiatan->volume;

            $program->pagu_anggaran = $program->pagu_anggaran + $grandgrandTotal;

            $program->save();


            return redirect()->route('program.show', ['program' => $kegiatan->id_program])->with('success', 'Kegiatan Berhasil Ditambahkan');

        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('program.show', ['program' => $kegiatan->id_program])->with('failed', 'Kegiatan Tidak Berhasil Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemKegiatan  $itemKegiatan
     * @return \Illuminate\Http\Response
     */
    public function show(ItemKegiatan $itemKegiatan)
    {
        $customcss = '';
        // $jmlsetting = Setting::where('group', 'env')->get();
        $settings = ['customcss' => $customcss,
                     'title' => 'Buat Program',
                     'baractive' => 'programbar',
                    ];
                    // foreach ($jmlsetting as $i => $set) {
                    //     $settings[$set->setname] = $set->value;
                    //  }

        $sisa_pagu_anggaran = $itemKegiatan->kegiatan->program->pagu_anggaran;

        return view('kegiatan.show', [
            $settings['baractive'] => 'active',
            'program' => $itemKegiatan->kegiatan->program,
            'renstra' => $itemKegiatan->kegiatan->program->renstra,
            'kegiatan' => $itemKegiatan->kegiatan,
            'sisa_pagu_anggaran' => $sisa_pagu_anggaran,
            'stgs' => $settings,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItemKegiatan  $itemKegiatan
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemKegiatan $itemKegiatan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ItemKegiatan  $itemKegiatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemKegiatan $itemKegiatan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemKegiatan  $itemKegiatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemKegiatan $itemKegiatan)
    {
        $program = $itemKegiatan->kegiatan->program;
        $grandTotal = $itemKegiatan->kegiatan->harga * $itemKegiatan->kegiatan->volume;

        $program->pagu_anggaran = $program->pagu_anggaran - $grandTotal;

        $program->save();

        $itemKegiatan->kegiatan->delete();

        return redirect()->route('program.show', ['program' => $program->id])->with('success', 'Kegiatan Berhasil dihapus');
    }
}
