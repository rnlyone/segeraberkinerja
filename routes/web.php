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


    Route::get('/program/{program}/show/{tahun}', [ProgramController::class, 'get_table'])->name('program.get.tahun');

    Route::get('/program/{program}/getdata', [ProgramController::class, 'get_data'])->name('program.get.data');



    Route::get('/penganggaran_program/{program}/show/{tahun}', [SKPDController::class, 'get_table'])->name('penganggaran.program.get.tahun');
    Route::post('/kegiatan/{kegiatan}/updatepagu', [KegiatanController::class, 'update_pagu'])->name('kegiatan.update.pagu');
    Route::get('/penganggaran_program/{program}', [SKPDController::class, 'programshow'])->name('penganggaran.program.show');
    Route::get('/penganggaran_program/{kegiatan}/getdata', [SKPDController::class, 'get_data'])->name('penganggaran.program.get.data');
    Route::get('/satuan/{satuan}/get_data', [SatuanController::class, 'get_data'])->name('satuan.get.data');
    Route::get('/kelompok/{kelompok}/get_data', [KelompokController::class, 'get_data'])->name('kelompok.get.data');
    Route::post('/import-satuan', [SatuanController::class, 'importSatuan'])->name('import.satuan');

    Route::get('logout', [UserController::class, 'logout'])->name('logout');
});

Route::get('/', function () {
    if (Auth::guest()) {
        return redirect()->route('flogin');
    } else {
        return redirect()->route('dashboard');
    }
});
