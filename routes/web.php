<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminDaerahController;
use App\Http\Controllers\Admin\DaerahController;
use App\Http\Controllers\Admin\PenumpangController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\Admin\SupirController;
use App\Http\Controllers\Penumppang\DashboardController;
use App\Http\Controllers\Penumppang\ProfileController as PenumppangProfileController;
use Illuminate\Support\Facades\Auth;
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
    return view('layouts.index');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Akun Admin 
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    // Update profile dan update password
    Route::get('/adminprofile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::put('/adminprofile', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::put('/adminprofilepassword', [ProfileController::class, 'updatepassword'])->name('admin.profile.updatepassword');
    // CRUD Akun Admin
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.admin.index');
    Route::get('/admincreate', [AdminController::class, 'create'])->name('admin.admin.create');
    Route::post('/adminstore', [AdminController::class, 'store'])->name('admin.admin.store');
    Route::get('/adminedit{id}', [AdminController::class, 'edit'])->name('admin.admin.edit');
    Route::put('/adminupdate{id}', [AdminController::class, 'update'])->name('admin.admin.update');
    Route::delete('/admindelete{id}', [AdminController::class, 'destroy'])->name('admin.admin.destroy');
    // CRUD Kategori Daerah
    Route::get('/daerahcreate', [DaerahController::class, 'create'])->name('admin.daerah.create');
    Route::post('/daerahstore', [DaerahController::class, 'store'])->name('admin.daerah.store');
    Route::get('/daerahedit{id}', [DaerahController::class, 'edit'])->name('admin.daerah.edit');
    Route::put('/daerahupdate{id}', [DaerahController::class, 'update'])->name('admin.daerah.update');
    Route::delete('/daerahdelete{id}', [DaerahController::class, 'destroy'])->name('admin.daerah.destroy');
    // CRUD Akun Admin Daerah
    Route::get('/admindaerah', [AdminDaerahController::class, 'index'])->name('admin.admindaerah.index');
    Route::get('/admindaerahcreate', [AdminDaerahController::class, 'create'])->name('admin.admindaerah.create');
    Route::post('/admindaerahstore', [AdminDaerahController::class, 'store'])->name('admin.admindaerah.store');
    Route::get('/admindaerahedit{id}', [AdminDaerahController::class, 'edit'])->name('admin.admindaerah.edit');
    Route::put('/admindaerahupdate{id}', [AdminDaerahController::class, 'update'])->name('admin.admindaerah.update');
    Route::delete('/admindaerahdelete{id}', [AdminDaerahController::class, 'destroy'])->name('admin.admindaerah.destroy');
    // CRUD Akun Supir
    Route::get('/supir', [SupirController::class, 'index'])->name('supir.supir.index');
    Route::get('/supircreate', [SupirController::class, 'create'])->name('supir.supir.create');
    Route::post('/supirstore', [SupirController::class, 'store'])->name('supir.supir.store');
    Route::get('/supiredit{id}', [SupirController::class, 'edit'])->name('supir.supir.edit');
    Route::put('/supirupdate{id}', [SupirController::class, 'update'])->name('supir.supir.update');
    Route::delete('/supirdelete{id}', [SupirController::class, 'destroy'])->name('supir.supir.destroy');
    // CRUD Akun Penumpang
    Route::get('/penumpang', [PenumpangController::class, 'index'])->name('penumpang.penumpang.index');
    Route::get('/penumpangcreate', [PenumpangController::class, 'create'])->name('penumpang.penumpang.create');
    Route::post('/penumpangstore', [PenumpangController::class, 'store'])->name('penumpang.penumpang.store');
    Route::get('/penumpangedit{id}', [PenumpangController::class, 'edit'])->name('penumpang.penumpang.edit');
    Route::put('/penumpangupdate{id}', [PenumpangController::class, 'update'])->name('penumpang.penumpang.update');
    Route::delete('/penumpangdelete{id}', [PenumpangController::class, 'destroy'])->name('penumpang.penumpang.destroy');
});

// Akun Penumpang
Route::middleware(['auth', 'user-access:penumpang'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('penumpang.dashboard');
    Route::get('/penumpangprofile', [PenumppangProfileController::class, 'index'])->name('penumpang.profile');
    Route::put('/penumpangprofile', [PenumppangProfileController::class, 'update'])->name('penumpang.profile.update');
    Route::put('/penumpangprofilepassword', [PenumppangProfileController::class, 'updatepassword'])->name('penumpang.profile.updatepassword');
});

// Lupa password
Route::get('password/reset', 'App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'App\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'App\Http\Controllers\Auth\ResetPasswordController@reset')->name('password.update');
