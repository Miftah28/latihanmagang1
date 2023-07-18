<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminDaerahController;
use App\Http\Controllers\admin\ProfileController;
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
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('/adminprofile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::put('/adminprofile', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::get('/admin', [AdminController::class,'index'])->name('admin.admin.index');
    Route::get('/admincreate', [AdminController::class,'create'])->name('admin.admin.create');
    Route::post('/adminstore', [AdminController::class,'store'])->name('admin.admin.store');
    Route::get('/adminedit{id}', [AdminController::class,'edit'])->name('admin.admin.edit');
    Route::put('/adminupdate{id}', [AdminController::class,'update'])->name('admin.admin.update');
    Route::delete('/admindelete', [AdminController::class,'destroy'])->name('admin.admin.destroy');
});
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
