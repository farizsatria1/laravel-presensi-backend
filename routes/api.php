<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
    
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//login Peserta
Route::post('/login', [App\Http\Controllers\Api\PesertaController::class, 'login']);
//login Peserta
Route::post('/logout', [App\Http\Controllers\Api\PesertaController::class, 'logout'])->middleware('auth:sanctum');


//login Pembimbing
Route::post('/login-pembimbing', [App\Http\Controllers\Api\PembimbingController::class, 'login']);
//login Pembimbing
Route::post('/logout-pembimbing', [App\Http\Controllers\Api\PesertaController::class, 'logout'])->middleware('auth:sanctum');

//show company
Route::get('/company', [App\Http\Controllers\Api\CompanyController::class, 'show'])->middleware('auth:sanctum');

