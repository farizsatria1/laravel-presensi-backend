<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PembimbingController;
use App\Http\Controllers\UserController;
use App\Models\Pembimbing;
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
    return view('pages.auth.auth-login');
});

Route::middleware(['auth'])->group(function () {
    
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    Route::resource('users', UserController::class);
    Route::resource('admins', AdminController::class);
    Route::resource('pembimbings', PembimbingController::class);

});
