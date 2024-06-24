<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\ActivityLogController;
use App\Models\InventoryTable;
use Milon\Barcode\DNS1D;
use App\Http\Controllers\AggregationController;
use App\Http\Controllers\BeritaAcaraController;
use App\Http\Controllers\DaftarRuanganController;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::resource('inventory', InventoryController::class);
Route::resource('user', UserController::class);
Route::resource('masuk', BarangMasukController::class);
Route::resource('keluar', BarangKeluarController::class);
Route::resource('ruangan', DaftarRuanganController::class);
Route::resource('berita_acara', BeritaAcaraController::class);


Route::controller(RoleController::class)->group(function () {
    Route::get('/role/create', 'create')->name('create role');
    Route::post('/role', 'save')->name('save role');
});

Route::get('/user', 'App\Http\Controllers\UserController@index')->name('user.index');
Route::post('/inventory/import', 'App\Http\Controllers\InventoryController@import')->name('inventory.import');
Route::get('/export-excel', 'App\Http\Controllers\InventoryController@exportExcel');
Route::get('/download-pdf', [DaftarRuanganController::class, 'downloadPDF'])
    ->name('download-pdf');
Route::get('/download-word', [DaftarRuanganController::class, 'downloadWord'])
    ->name('download-word');
Route::post('/inventory/search', 'App\Http\Controllers\InventoryController@search')->name('inventory.search');
// Add other routes for create, store, edit, update, and destroy as needed


Route::get('/generate-barcode', [InventoryController::class, 'generateBarcode'])
    ->name('generate-barcode');

Route::get('/export-inventory', 'App\Http\Controllers\InventoryController@export')->name('export-inventory');
Route::get('/recent-activities', 'App\Http\Controllers\ActivityLogController@showRecentActivities');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/dashboard', 'App\Http\Controllers\ActivityLogController@index')->name('dashboard');
});
Route::get('/get-kategori-data', 'App\Http\Controllers\ActivityLogController@getInventoryData');
Route::post('/aggregate-data', 'App\Http\Controllers\AggregationController@aggregateAndStore')->name('aggregate-data');
Route::middleware(['log'])->group(function () {
    // Routes that should log activities
});
