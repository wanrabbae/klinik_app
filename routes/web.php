<?php

use App\Http\Controllers\AuthCtrl;
use App\Http\Controllers\DashboardCtrl;
use App\Http\Controllers\DokterCtrl;
use App\Http\Controllers\InfografisCtrl;
use App\Http\Controllers\PasienCtrl;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\TindakanCtrl;
use App\Http\Controllers\TransactionCtrl;
use Illuminate\Support\Facades\Route;

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

// AUTH ROUTES
Route::get('/login', [AuthCtrl::class, 'loginView'])->name('login');
Route::post('/auth', [AuthCtrl::class, 'auth'])->name('auth');
Route::get('/logout', [AuthCtrl::class, 'logout'])->name('logout');

// DASHBOARD ROUTES
Route::get('/', [DashboardCtrl::class, 'index'])->name('dashboard')->middleware('auth');

// TRANSACTION ROUTES
Route::get('/transaction', [TransactionCtrl::class, 'index'])->name('transaction.index')->middleware('auth');
Route::post('/transaction', [TransactionCtrl::class, 'store'])->name('transaction.store')->middleware('auth');
Route::get('/transaction/delete/{id}', [TransactionCtrl::class, 'destroy'])->name('transaction.delete')->middleware('auth');
Route::get('/transaction_preview', [TransactionCtrl::class, 'preview'])->name('transaction.preview')->middleware('auth');
Route::post('/download-nota', [PDFController::class, 'downloadPDF']);

// TRANSACTION TINDAKAN ROUTES
Route::get('/transaction/tindakan/delete/{id}', [TransactionCtrl::class, 'destroyTindakan'])->name('transaction_tindakan.delete')->middleware('auth');

// PASIEN ROUTES
Route::get('/pasien', [PasienCtrl::class, 'index'])->name('pasien.index')->middleware('auth');
Route::get('/preview_pasien', [PasienCtrl::class, 'preview'])->name('pasien.preview')->middleware('auth');
Route::post('/pasien', [PasienCtrl::class, 'store'])->name('pasien.post')->middleware('auth');
Route::post('/pasien/update/{id}', [PasienCtrl::class, 'update'])->name('pasien.put')->middleware('auth');
Route::get('/pasien/delete/{id}', [PasienCtrl::class, 'delete'])->name('pasien.delete')->middleware('auth');

// TINDAKAN ROUTES
Route::get('/tindakan', [TindakanCtrl::class, 'index'])->name('tindakan.index')->middleware('auth');
Route::get('/tindakan/preview/{id}', [TindakanCtrl::class, 'preview'])->name('tindakan.preview')->middleware('auth');
Route::post('/tindakan', [TindakanCtrl::class, 'store'])->name('tindakan.post')->middleware('auth');
Route::post('/tindakan/update/{id}', [TindakanCtrl::class, 'update'])->name('tindakan.put')->middleware('auth');
Route::get('/tindakan/delete/{id}', [TindakanCtrl::class, 'delete'])->name('tindakan.delete')->middleware('auth');

// DOKTER ROUTES
Route::get('/dokter', [DokterCtrl::class, 'index'])->name('dokter.index')->middleware('auth');
Route::post('/dokter', [DokterCtrl::class, 'store'])->name('dokter.post')->middleware('auth');
Route::post('/dokter/update/{id}', [DokterCtrl::class, 'update'])->name('dokter.put')->middleware('auth');
Route::get('/dokter/delete/{id}', [DokterCtrl::class, 'delete'])->name('dokter.delete')->middleware('auth');
Route::get('/kinerja', [DokterCtrl::class, 'kinerja'])->name('dokter.kinerja.index')->middleware('auth');
Route::get('/lapor_kinerja', [DokterCtrl::class, 'kinerjaPost'])->name('dokter.kinerja.laporan')->middleware('auth');
Route::get('/kinerja/download', [PDFController::class, 'downloadExcel'])->name('dokter.kinerja.laporan')->middleware('auth');


// INFOGRAFIS ROUTES
Route::get('/infografis', [InfografisCtrl::class, 'index'])->name('infografis.index')->middleware('auth');
