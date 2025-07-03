<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KoleksiController;
use App\Http\Controllers\ProfilController;
use App\Http\Middleware\IsAdmin;

Route::get('/', [HomeController::class, 'index'])->name('beranda');

// Admin
Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // USER
    Route::delete('/admin/user/{id}', [AdminController::class, 'delete_user'])->name('admin.delete.user');
    Route::put('/admin/update-user/{id}', [AdminController::class, 'updateUser'])->name('admin.update.user');


    // DESAIN
    Route::get('admin/list_desain', [AdminController::class, 'list_desain'])->name('admin.list.desain');
    Route::get('admin/tambah_desain', [AdminController::class, 'tambah_desain'])->name('admin.tambah.desain');
    Route::post('admin/upload_desain', [AdminController::class, 'upload_desain'])->name('admin.upload.desain');
    Route::delete('/admin/delete_desain/{id}', [AdminController::class, 'delete_desain'])->name('admin.delete.desain');
    Route::put('admin/update_desain/{id}', [AdminController::class, 'update_desain'])->name('admin.update.desain');

    // TRANSAKSI
    Route::get('admin/list_transaksi', [AdminController::class, 'list_transaksi'])->name('admin.list.transaksi');
    Route::put('/admin/transaksi/{id}', [AdminController::class, 'update_transaksi'])->name('admin.update.transaksi');
});

// Home
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/kebijakan_privasi', [HomeController::class, 'kebijakan_privasi'])->name('kebijakan.privasi');
Route::get('/syarat_ketentuan', [HomeController::class, 'syarat_ketentuan'])->name('syarat.ketentuan');
Route::get('/form_faq', [HomeController::class, 'form_faq'])->name('form.faq');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');

// Koleksi
Route::get('/koleksi', [KoleksiController::class, 'index'])->name('koleksi');
Route::get('/koleksi/detail/{id}', [KoleksiController::class, 'detail'])->name('koleksi.detail');
Route::middleware('auth')->get('/beli/{id}', [KoleksiController::class, 'beli'])->name('koleksi.beli');


// Profil
Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
Route::post('/profil/update-photo', [ProfilController::class, 'updatePhoto'])->name('profil.updatePhoto');
Route::post('/profil/update-profil', [ProfilController::class, 'updateProfil'])->name('profil.updateProfil');
Route::middleware('auth')->get('/history', [ProfilController::class, 'history'])->name('history');
Route::post('/rating', [ProfilController::class, 'storeRating'])->middleware('auth')->name('rating.store');
Route::delete('/history/{id}', [App\Http\Controllers\ProfilController::class, 'delete_history'])->name('delete.history');



// Auth
Route::get('/register', [AuthController::class, 'formRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'formLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');