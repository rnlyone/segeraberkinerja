<?php

namespace App\Http\Controllers;

use App\Models\ItemKegiatan;
use App\Models\Kegiatan;
use App\Models\Kelompok;
use App\Models\Komponen;
use App\Models\Program;
use App\Models\Renstra;
use App\Models\Satuan;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
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
        // dd($request);
        $skpd = auth()->user()->skpd;

        // Validasi request sesuai kebutuhan
        $validatedData = $request->validate([
            'kode' => 'required|string',
            'nama_sub' => 'required|string',
            'satuan' => 'required|string',
            // Tambahkan validasi untuk kolom lainnya sesuai kebutuhan
        ]);
        // Mendapatkan semua parameters dari request

        try{

            $sub = new ItemKegiatan;
            $sub->id_kegiatan = $request->id_kegiatan;
            $sub->kode = $validatedData['kode'];
            $sub->nama_sub = $validatedData['nama_sub'];
            $sub->satuan = $validatedData['satuan'];

            $sub->save();

            return redirect()->back()->with('success', 'Sub Kegiatan Berhasil Ditambahkan');

        } catch (\Throwable $th) {
            dd($th);
            return redirect()->back()->with('failed', 'Kegiatan Tidak Berhasil Ditambahkan');
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

        $satuans = Satuan::all();
        $kelompoks = Kelompok::all();

        return view('itemkegiatan.show', [
            $settings['baractive'] => 'active',
            'satuans' => $satuans,
            'kelompoks' => $kelompoks,
            'program' => $itemKegiatan->kegiatan->program,
            'renstra' => $itemKegiatan->kegiatan->program->renstra,
            'kegiatan' => $itemKegiatan->kegiatan,
            'item_kegiatan' => $itemKegiatan,
            'sisa_pagu_anggaran' => $sisa_pagu_anggaran,
            'stgs' => $settings,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemKegiatan  $itemKegiatan
     * @return \Illuminate\Http\Response
     */
    public function print(ItemKegiatan $itemKegiatan) {
        $customcss = '';
        // $jmlsetting = Setting::where('group', 'env')->get();
        $settings = [
            'customcss' => $customcss,
            'title' => 'Buat Program',
            'baractive' => 'programbar',
        ];
        // foreach ($jmlsetting as $i => $set) {
        //     $settings[$set->setname] = $set->value;
        // }

        // Check if the relations exist before accessing them
        $sisa_pagu_anggaran = optional($itemKegiatan->kegiatan->program)->pagu_anggaran ?? null;

        $satuans = Satuan::all();
        $kelompoks = Kelompok::all();

        // Adjust the view data accordingly
        $pdf = FacadePdf::loadview('itemkegiatan.print', [
            $settings['baractive'] => 'active',
            'satuans' => $satuans,
            'kelompoks' => $kelompoks,
            'program' => optional($itemKegiatan->kegiatan)->program,
            'renstra' => optional($itemKegiatan->kegiatan->program)->renstra,
            'kegiatan' => $itemKegiatan->kegiatan,
            'item_kegiatan' => $itemKegiatan,
            'sisa_pagu_anggaran' => $sisa_pagu_anggaran,
            'stgs' => $settings
        ])->setOptions(['defaultFont' => 'sans-serif']);

        return $pdf->download('laporan-sub-kegiatan-pdf');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItemKegiatan  $itemKegiatan
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemKegiatan $itemKegiatan)
    {

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
        $skpd = $itemKegiatan->kegiatan->program->renstra->skpd;
        $kegiatan = $itemKegiatan->kegiatan;

        $allParameters = $request->all();

        //delete all komponen sub kegiatan
        $kegiatan->pagu_anggaran -= $itemKegiatan->pagu_anggaran;
        $kegiatan->save();

        $itemKegiatan->pagu_anggaran = 0;
        $itemKegiatan->save();

        if ($itemKegiatan->komponens->isNotEmpty()) {
            foreach ($itemKegiatan->komponens as $komponen) {
                $komponen->delete();
            }
        }
        //delete all komponen sub kegiatan selesai

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

        foreach ($numericAttributes as $key => $value) {
            $index = strtok($key, '_'); // Mengambil bagian index dari kunci
            $property = substr($key, strpos($key, '_') + 1); // Mengambil sisa kunci setelah index

            if (!isset($result[$index])) {
                $result[$index] = []; // Inisialisasi array jika belum ada
            }

            $result[$index][$property] = $value; // Memasukkan nilai ke dalam objek dengan index yang sesuai
        }
        // dd($result);

        try {
            foreach ($result as $i => $value) {
                $komponen = new Komponen();

                $komponen->id_item = $itemKegiatan->id;
                $komponen->id_satuan = $value['id_item'];
                $komponen->volume = $value['volume_item_kegiatan'];

                $komponen->save();

                $totalItem[$komponen->id] = $komponen->satuan->harga * $komponen->volume;
            }

            $grandTotal = 0;

            // Loop melalui array $totalItem untuk menjumlahkan nilai
            foreach ($totalItem as $itemTotal) {
                $grandTotal += $itemTotal;
            }

            $itemKegiatan->pagu_anggaran = $grandTotal;
            $itemKegiatan->save();

            $kegiatan->pagu_anggaran += $grandTotal;
            $kegiatan->save();

            return redirect()->route('kegiatan.show', ['kegiatan' => $kegiatan->id])->with('success', 'Sub Kegiatan Berhasil di Edit');

        } catch (\Throwable $th) {
            return redirect()->back()->with('failed', 'Sub Kegiatan Tidak Berhasil di Edit');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemKegiatan  $itemKegiatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemKegiatan $itemKegiatan)
    {
        $kegiatan = $itemKegiatan->kegiatan;

        $kegiatan->pagu_anggaran = $kegiatan->pagu_anggaran - $itemKegiatan->pagu_anggaran;
        $kegiatan->pagu_indikatif = $kegiatan->pagu_indikatif - $itemKegiatan->pagu_indikatif;

        $kegiatan->save();

        $itemKegiatan->delete();

        return redirect()->route('kegiatan.show', ['kegiatan' => $kegiatan->id])->with('success', 'Sub Kegiatan Berhasil dihapus');
    }
}
