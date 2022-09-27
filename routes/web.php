<?php

use App\Http\Controllers\BarangController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/admin', function () {
    return view('content.barang');
})->middleware('role:admin')->name('admin');

Route::get('/getBarang', [BarangController::class, 'index'])->name('getBarang');
Route::get('/exportExcel', [BarangController::class, 'exportExcel'])->name('exportExcel');
Route::post('/importExcel', [BarangController::class, 'importExcel'])->name('importExcel');
Route::get('/template', [BarangController::class, 'template'])->name('template');




