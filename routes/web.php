<?php

use App\Http\Controllers\PrinterThermalController;
use App\Http\Controllers\WEB\AdminController;
use App\Http\Controllers\WEB\BiayaParkirController;
use App\Http\Controllers\WEB\ConfigHargaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WEB\TestController;
use App\Http\Controllers\WEB\LoginController;
use App\Http\Controllers\Web\PenggunaController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\WEB\ValidasiController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::prefix('admin')->middleware(['auth', 'check.role:admin'])->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::resource('/penggunas', PenggunaController::class);
    Route::get('/valid', [ValidasiController::class, 'showForm']);
    Route::get('/pembayaran', [BiayaParkirController::class,'index'])->name('admin.pembayaran');
    Route::get('/pembayaran/now', [BiayaParkirController::class,'paymentsNow'])->name('admin.pembayaran.now');
});

Route::prefix('manajemen')->middleware(['auth', 'check.role:manajemen'])->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::resource('/penggunas', PenggunaController::class);
    Route::get('/penggunas/cetak_pdf', [PenggunaController::class, 'cetakpengguna']);
    Route::get('/cetakpengguna/{pengguna}', [PenggunaController::class, 'cetakqr'])->name('cetakqr');
    Route::get('/form', [PenggunaController::class, 'showForm']);
    Route::get('/valid', [ValidasiController::class, 'showForm']);
    Route::get('/pembayaran', [BiayaParkirController::class,'index'])->name('manajemen.pembayaran');
    Route::get('/pembayaran/now', [BiayaParkirController::class,'paymentsNow'])->name('manajemen.pembayaran.now');;
    Route::get('/harga', [ConfigHargaController::class, 'form'])->name('manajemen.updateharga');
    Route::resource('/admin', AdminController::class);
    
});
Route::get('/get-chart-data', [DashboardController::class, 'getChartData'])->name('getChartData');
Route::get('/get-time', [DashboardController::class, 'getCurrentTime']);
Route::get('/get-payments', [DashboardController::class, 'transaksi'])->name('getPayments');
Route::get('/get-slot', [DashboardController::class, 'slot'])->name('getSlot');
Route::post('/update/harga', [ConfigHargaController::class, 'update']);


Route::get('/penggunas/cetak_pdf',[PenggunaController::class, 'cetakpengguna']);

Route::get('/cetakpengguna/{pengguna}', [PenggunaController::class, 'cetakqr'])->name('cetakqr');
Route::get('/qr/{nim}', [PenggunaController::class, 'generate'])->name('generate');

//proses form input pengguna
Route::post('/process-form', [PenggunaController::class, 'processForm']);
//pencarian
Route::get('/pengguna/cari', [PenggunaController::class, 'cari']);



Route::post('/valid-In', [ValidasiController::class, 'processIn']);
Route::post('/valid-Out', [ValidasiController::class, 'processOut']);
Route::get('/kejadian', [ValidasiController::class, 'laporan']);
Route::get('/kejadian/cetak_pdf',[ValidasiController::class, 'cetakpdf'])->name('cetak.pdf');
Route::get('/kejadian/cari', [ValidasiController::class, 'cari']);
Route::get('/cetak-filter-pdf', [ValidasiController::class, 'cariFilterPdf'])->name('cetak.filtered.pdf');


//config harga

Route::post('/update/harga', [ConfigHargaController::class, 'update'])->name('harga.update');

//pembayaran yang ada


// routes/web.php

// Route::get('/open-gate', [ValidasiController::class, 'openGate'])->name('open-gate');
Route::get('/toggle-door', [DashboardController::class, 'toggleDoorStatus'])->name('toggle-door');



Route::get('/pusher', function(){
    return view('pusher');
});

Route::get('/print-view', [PrinterThermalController::class, 'index'])->name('print.view');

Route::get('/print-struk', [PrinterThermalController::class, 'print'])->name('print.struk');

