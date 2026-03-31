<?php

// use Illuminate\Support\Facades\Route;

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


// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/master-items', [App\Http\Controllers\MasterItemsController::class, 'index']);
// Route::get('/master-items/search', [App\Http\Controllers\MasterItemsController::class, 'search']);
// Route::get('/master-items/form/{method}/{id?}', [App\Http\Controllers\MasterItemsController::class, 'formView']);
// Route::post('/master-items/form/{method}/{id?}', [App\Http\Controllers\MasterItemsController::class, 'formSubmit']);

// Route::get('/master-items/view/{kode}', [App\Http\Controllers\MasterItemsController::class, 'singleView']);
// Route::get('/master-items/delete/{id}', [App\Http\Controllers\MasterItemsController::class, 'delete']);


// Route::get('/master-items/update-random-data', [App\Http\Controllers\MasterItemsController::class, 'updateRandomData']);


// use App\Http\Controllers\CategoryController;

// // Grouping agar lebih rapi
// Route::prefix('categories')->group(function () {
//     // Halaman utama daftar kategori
//     Route::get('/', [CategoryController::class, 'index']);

//     // Endpoint AJAX untuk pencarian/data table
//     Route::get('/search', [CategoryController::class, 'search']);

//     // Menampilkan form (method 'new' atau 'edit')
//     Route::get('/form/{method}/{id?}', [CategoryController::class, 'formView']);

//     // Proses simpan data (Tambah/Update)
//     Route::post('/submit/{method}/{id?}', [CategoryController::class, 'formSubmit']);

//     // Halaman View Single (Poin 3: Detail & List Items)
//     Route::get('/view/{id}', [CategoryController::class, 'singleView']);

//     // Proses Hapus
//     Route::get('/delete/{id}', [CategoryController::class, 'delete']);
// });

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterItemsController;
use App\Http\Controllers\CategoryController;

Auth::routes();

// Home Dashboard
Route::get('/', [HomeController::class, 'index'])->name('home');

// Master Items Group
// Master Items Group
Route::prefix('master-items')->group(function () {
    Route::get('/', [MasterItemsController::class, 'index']);
    Route::get('/search', [MasterItemsController::class, 'search']);
    
    // 1. PINDAHKAN SUBMIT KE SINI DAN UBAH '/form' JADI '/submit'
    // Agar sesuai dengan <form action="{{ url('master-items/submit/...') }}">
    Route::post('/submit/{method}/{id?}', [MasterItemsController::class, 'formSubmit']);
    
    // 2. Route view/single taruh DI BAWAH submit agar tidak dianggap kode barang
    Route::get('/view/{kode}', [MasterItemsController::class, 'singleView']);
    Route::get('/delete/{id}', [MasterItemsController::class, 'delete']);
    
    // Form View (GET)
    Route::get('/form/{method}/{id?}', [MasterItemsController::class, 'formView']);
    
    // Utility
    Route::get('/update-random-data', [MasterItemsController::class, 'updateRandomData']);
});

// Categories Group
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/search', [CategoryController::class, 'search']);
    Route::get('/view/{id}', [CategoryController::class, 'singleView']);
    Route::get('/delete/{id}', [CategoryController::class, 'delete']);
    
    // Form handling
    Route::get('/form/{method}/{id?}', [CategoryController::class, 'formView']);
    Route::post('/submit/{method}/{id?}', [CategoryController::class, 'formSubmit']);
});