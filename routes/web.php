<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
// use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PeminjamanControllerr;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

// --- Rute untuk Tamu (Guest) ---
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

    // Rute Register
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register.show');
    Route::post('register', [RegisterController::class, 'register'])->name('register.submit');

    // Rute Login
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login.show');
    Route::post('login', [LoginController::class, 'login'])->name('login.submit');
});


// --- Rute yang Membutuhkan Login (User & Admin) ---
Route::middleware('auth')->group(function () {

    // Rute Logout
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Rute default untuk User (Anggota)
    Route::get('/units', [UnitController::class, 'index'])->name('units.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');


    Route::post('/pinjam', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman-saya', [PeminjamanController::class, 'myPeminjaman'])->name('peminjaman.saya');
});


// --- Rute Khusus Admin ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // --- TAMBAHKAN INI ---
    // Poin 9: CRUD Unit, Kategori, User
    Route::resource('units', \App\Http\Controllers\Admin\UnitController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);


    Route::get('/peminjaman-aktif', [\App\Http\Controllers\Admin\PeminjamanController::class, 'index'])
        ->name('peminjaman.aktif');

    // Poin 12: Hanya Admin yang dapat melakukan pengembalian unit
    // Kita gunakan method PATCH untuk 'meng-update' status peminjaman
    Route::patch('/peminjaman/{peminjaman}/kembalikan', [\App\Http\Controllers\Admin\PeminjamanController::class, 'kembalikan'])
        ->name('peminjaman.kembalikan');

    Route::get('/peminjaman-history', [\App\Http\Controllers\Admin\PeminjamanController::class, 'history'])
        ->name('admin.peminjaman.histori');

    // Poin 15: Halaman khusus untuk mencetak
    Route::get('/peminjaman-history/print', [\App\Http\Controllers\Admin\PeminjamanController::class, 'print'])
        ->name('admin.peminjaman.print');
});