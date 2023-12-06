<?php

use App\Http\Controllers\HSPKController;
use App\Http\Controllers\ItemKegiatanController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\KelompokController;
use App\Http\Controllers\KomponenController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\RenstraController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\SKPDController;
use App\Http\Controllers\SusunanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware'=> ['guest']], function(){
    Route::get('login', [UserController::class, 'flogin'])->name('flogin');
    Route::post('login', [UserController::class, 'login'])->name('login');
});

Route::group(['middleware'=> ['auth']], function(){
    Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::resource('skpd', SKPDController::class);
    Route::resource('renstra', RenstraController::class);
    Route::resource('program', ProgramController::class);
    Route::resource('kegiatan', KegiatanController::class);
    Route::resource('item_kegiatan', ItemKegiatanController::class);
    Route::resource('komponen', KomponenController::class);
    Route::resource('satuan', SatuanController::class);
    Route::resource('susunan', SusunanController::class);


    Route::get('/program/{program}/show/{tahun}', [ProgramController::class, 'get_table'])->name('program.get.tahun');

    Route::get('/program/{program}/getdata', [ProgramController::class, 'get_data'])->name('program.get.data');



    Route::get('/penganggaran_program/{program}/show/{tahun}', [SKPDController::class, 'get_table'])->name('penganggaran.program.get.tahun');
    Route::post('/kegiatan/{kegiatan}/updatepagu', [KegiatanController::class, 'update_pagu'])->name('kegiatan.update.pagu');
    Route::get('/penganggaran_program/{program}', [SKPDController::class, 'programshow'])->name('penganggaran.program.show');
    Route::get('/penganggaran_program/{kegiatan}/getdata', [SKPDController::class, 'get_data'])->name('penganggaran.program.get.data');
    Route::get('/satuan/{satuan}/get_data', [SatuanController::class, 'get_data'])->name('satuan.get.data');
    Route::get('/kelompok/{kelompok}/get_data', [KelompokController::class, 'get_data'])->name('kelompok.get.data');
    Route::post('/import-satuan', [SatuanController::class, 'importSatuan'])->name('import.satuan');

    Route::get('/delete-satuan/{jenis_satuan}', [SatuanController::class, 'destroy'])->name('delete.satuan');

    Route::get('logout', [UserController::class, 'logout'])->name('logout');
});

route::get('/video-panduan', function(){
    return redirect()->intended('https://drive.google.com/drive/folders/1DiEORDBZAZ8TQ1msk3mZaxqPHh5kfekj?usp=sharing');
});


route::get('/buku-panduan', function(){
    return redirect()->intended('https://drive.google.com/drive/folders/1fES2AbcDX9sYfmujkm-Ixq-qKIGqwJfk?usp=drive_link');
});

Route::get('/', function () {
    if (Auth::guest()) {
        return redirect()->route('flogin');
    } else {
        return redirect()->route('dashboard');
    }
});
