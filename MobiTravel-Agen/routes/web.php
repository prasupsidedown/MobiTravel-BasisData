<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AgenController;

Route::post('/coba-register', function() {
    return 'Route coba-register berhasil! Data: ' . json_encode(request()->all());
});

Route::post('/daftar-agen', [AuthController::class, 'registerAgen'])->name('register.agen.post');
// ============ HALAMAN PUBLIK ============
Route::get('/', function () {
    return view('welcome');
});

Route::get('/agen-list', function () {
    return view('agen-list');
});

Route::get('/destinasi', function () {
    return view('destinasi');
});

Route::get('/ulasan', function () {
    return view('ulasan');
});

Route::get('/coba', function() {
    return view('coba');
});

// ============ AUTHENTIKASI ============
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register/agen', [AuthController::class, 'showRegisterAgen'])->name('register.agen');
Route::post('/register/agen', [AuthController::class, 'registerAgen']);
Route::post('/login/agen', [AuthController::class, 'loginAgen']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ============ DASHBOARD AGEN (HARUS LOGIN) ============
Route::middleware('auth.agen')->group(function () {
    Route::get('/dashboard', [AgenController::class, 'dashboard']);
    
    // Trip
    Route::post('/trip/tambah', [AgenController::class, 'tambahTrip']);
    Route::post('/trip/edit', [AgenController::class, 'editTrip']);
    Route::post('/trip/hapus/{id}', [AgenController::class, 'hapusTrip']);
    
    // Wisata
    Route::post('/wisata/tambah', [AgenController::class, 'tambahWisata']);
    Route::post('/wisata/edit', [AgenController::class, 'editWisata']);
    Route::post('/wisata/hapus/{id}', [AgenController::class, 'hapusWisata']);
    
    // Akun
    Route::post('/agen/akun/update', [AgenController::class, 'updateAkun']);
});