<?php

use App\Http\Controllers\AuthCtrl;
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

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');

Route::get('/login', [AuthCtrl::class, 'loginView'])->name('login');
Route::post('/auth', [AuthCtrl::class, 'auth'])->name('auth');
Route::get('/logout', [AuthCtrl::class, 'logout'])->name('logout');
