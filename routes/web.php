<?php

use App\Http\Controllers\AuthCtrl;
use App\Http\Controllers\DashboardCtrl;
use App\Http\Controllers\DokterCtrl;
use App\Http\Controllers\PasienCtrl;
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

// PASIEN ROUTES
Route::get('/pasien', [PasienCtrl::class, 'index'])->name('pasien.index')->middleware('auth');
Route::get('/preview-pasien/{id}', [PasienCtrl::class, 'preview'])->name('pasien.index')->middleware('auth');
Route::post('/pasien', [PasienCtrl::class, 'store'])->name('pasien.post')->middleware('auth');
Route::post('/pasien/update/{id}', [PasienCtrl::class, 'update'])->name('pasien.put')->middleware('auth');
Route::get('/pasien/delete/{id}', [PasienCtrl::class, 'delete'])->name('pasien.delete')->middleware('auth');

// TINDAKAN ROUTES
Route::get('/tindakan', [TindakanCtrl::class, 'index'])->name('tindakan.index')->middleware('auth');

// DOKTER ROUTES
Route::get('/dokter', [DokterCtrl::class, 'index'])->name('dokter.index')->middleware('auth');
Route::get('/kinerja', [DokterCtrl::class, 'kinerja'])->name('dokter.kinerja.index')->middleware('auth');
