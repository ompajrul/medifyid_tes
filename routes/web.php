<?php

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
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/master-items', [App\Http\Controllers\MasterItemsController::class, 'index']);
Route::get('/master-items/search', [App\Http\Controllers\MasterItemsController::class, 'search']);
Route::get('/master-items/form/{method}/{id?}', [App\Http\Controllers\MasterItemsController::class, 'formView']);
Route::post('/master-items/form/{method}/{id?}', [App\Http\Controllers\MasterItemsController::class, 'formSubmit']);

Route::get('/master-items/view/{kode}', [App\Http\Controllers\MasterItemsController::class, 'singleView']);
Route::get('/master-items/delete/{id}', [App\Http\Controllers\MasterItemsController::class, 'delete']);


Route::get('/master-items/update-random-data', [App\Http\Controllers\MasterItemsController::class, 'updateRandomData']);


use App\Http\Controllers\CategoryController;

// Grouping agar lebih rapi
Route::prefix('categories')->group(function () {
    // Halaman utama daftar kategori
    Route::get('/', [CategoryController::class, 'index']);

    // Endpoint AJAX untuk pencarian/data table
    Route::get('/search', [CategoryController::class, 'search']);

    // Menampilkan form (method 'new' atau 'edit')
    Route::get('/form/{method}/{id?}', [CategoryController::class, 'formView']);

    // Proses simpan data (Tambah/Update)
    Route::post('/submit/{method}/{id?}', [CategoryController::class, 'formSubmit']);

    // Halaman View Single (Poin 3: Detail & List Items)
    Route::get('/view/{id}', [CategoryController::class, 'singleView']);

    // Proses Hapus
    Route::get('/delete/{id}', [CategoryController::class, 'delete']);
});