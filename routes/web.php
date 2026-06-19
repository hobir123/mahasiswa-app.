<?php

use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MahasiswaController::class, 'index'])->name('mahasiswa.index');

// Route Actions Mahasiswa
Route::post('/mahasiswa/store', [MahasiswaController::class, 'storeMahasiswa'])->name('mahasiswa.storeMahasiswa');
Route::put('/mahasiswa/update/{id}', [MahasiswaController::class, 'updateMahasiswa'])->name('mahasiswa.updateMahasiswa');
Route::delete('/mahasiswa/delete/{id}', [MahasiswaController::class, 'destroyMahasiswa'])->name('mahasiswa.destroyMahasiswa');

// Route Actions Absen Rekap
Route::post('/absensi/store', [MahasiswaController::class, 'store'])->name('absensi.store');