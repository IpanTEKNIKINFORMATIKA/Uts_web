<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// Authentication (Hanya untuk Guest)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

// ==========================================
// Halaman yang Memerlukan Login (Middleware Auth)
// ==========================================
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ---- JURUSAN ----
    Route::prefix('jurusan')->name('jurusan.')->group(function () {
        Route::get('/',           [JurusanController::class, 'index'])->name('index');
        Route::get('/tambah',     [JurusanController::class, 'tambah'])->name('tambah');
        Route::post('/simpan',    [JurusanController::class, 'simpan'])->name('simpan');
        Route::get('/{id}/ubah',  [JurusanController::class, 'ubah'])->name('ubah');
        Route::put('/{id}',       [JurusanController::class, 'update'])->name('update');
        Route::delete('/{id}',    [JurusanController::class, 'hapus'])->name('hapus');
    });

    // ---- MAHASISWA ----
    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/',           [MahasiswaController::class, 'index'])->name('index');
        Route::get('/tambah',     [MahasiswaController::class, 'tambah'])->name('tambah');
        Route::post('/simpan',    [MahasiswaController::class, 'simpan'])->name('simpan');
        Route::get('/{id}/ubah',  [MahasiswaController::class, 'ubah'])->name('ubah');
        Route::put('/{id}',       [MahasiswaController::class, 'update'])->name('update');
        Route::delete('/{id}',    [MahasiswaController::class, 'hapus'])->name('hapus');
    });

    // ---- MATAKULIAH ----
    Route::prefix('matakuliah')->name('matakuliah.')->group(function () {
        Route::get('/',           [MatakuliahController::class, 'index'])->name('index');
        Route::get('/tambah',     [MatakuliahController::class, 'tambah'])->name('tambah');
        Route::post('/simpan',    [MatakuliahController::class, 'simpan'])->name('simpan');
        Route::get('/{id}/ubah',  [MatakuliahController::class, 'ubah'])->name('ubah');
        Route::put('/{id}',       [MatakuliahController::class, 'update'])->name('update');
        Route::delete('/{id}',    [MatakuliahController::class, 'hapus'])->name('hapus');
    });
});
