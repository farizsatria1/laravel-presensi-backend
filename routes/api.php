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
//logout Peserta
Route::post('/logout', [App\Http\Controllers\Api\PesertaController::class, 'logout'])->middleware('auth:sanctum');


//login Pembimbing
Route::post('/login-pembimbing', [App\Http\Controllers\Api\PembimbingController::class, 'login']);
//login Pembimbing
Route::post('/logout-pembimbing', [App\Http\Controllers\Api\PembimbingController::class, 'logout'])->middleware('auth:sanctum');

//show company
Route::get('/company', [App\Http\Controllers\Api\CompanyController::class, 'show'])->middleware('auth:sanctum');

//checkin
Route::post('/checkin', [App\Http\Controllers\Api\AttendanceController::class, 'checkin'])->middleware('auth:sanctum');

//checkout
Route::post('/checkout', [App\Http\Controllers\Api\AttendanceController::class, 'checkout'])->middleware('auth:sanctum');

//is checked in
Route::get('/is-checkin', [App\Http\Controllers\Api\AttendanceController::class, 'isCheckedin'])->middleware('auth:sanctum');

//update profile peserta
Route::post('/update-profile', [App\Http\Controllers\Api\PesertaController::class, 'updateProfile'])->middleware('auth:sanctum');

//create permission
Route::apiResource('/api-permissions', App\Http\Controllers\Api\PermissionController::class)->middleware('auth:sanctum');

//get permission
Route::get('/api-get-permissions',[App\Http\Controllers\Api\PermissionController::class, 'show'])->middleware('auth:sanctum');

//get permission for pembimbing
Route::get('/api-get-permissions/{user_id}',[App\Http\Controllers\Api\PermissionController::class, 'index'])->middleware('auth:sanctum');

//get attendance
Route::get('/api-attendances', [App\Http\Controllers\Api\AttendanceController::class, 'index'])->middleware('auth:sanctum');

//get attendance by id
Route::get('/api-attendances/{user_id}', [App\Http\Controllers\Api\AttendanceController::class, 'getAttendanceById'])->middleware('auth:sanctum');

//get late attendance
Route::get('/api-late-attendances', [App\Http\Controllers\Api\AttendanceController::class, 'lateAttendance'])->middleware('auth:sanctum');

//get not attendance
Route::get('/api-not-attendances', [App\Http\Controllers\Api\AttendanceController::class, 'notAbsentToday'])->middleware('auth:sanctum');

//get not attendance today
Route::get('/api-not-attendances', [App\Http\Controllers\Api\AttendanceController::class, 'notAbsentToday'])->middleware('auth:sanctum');

//get peserta
Route::get('/api-get-peserta',[App\Http\Controllers\Api\PesertaController::class, 'show'])->middleware('auth:sanctum');

//create progress
Route::post('/create-progress', [App\Http\Controllers\Api\ProgressController::class, 'store'])->middleware('auth:sanctum');

//get pembimbing
Route::get('/api-get-pembimbing', [App\Http\Controllers\Api\PembimbingController::class, 'index'])->middleware('auth:sanctum');

//get peserta kecuali yang login
Route::get('/api-get-peserta-for-progress',[App\Http\Controllers\Api\PesertaController::class, 'getPeserta'])->middleware('auth:sanctum');

//get progress hari ini by user_id
Route::get('/api-get-progress', [App\Http\Controllers\Api\ProgressController::class, 'getProgress'])->middleware('auth:sanctum');

//get progress yang ditolak by user_id
Route::get('/api-get-progress-ditolak', [App\Http\Controllers\Api\ProgressController::class, 'getProgressDitolak'])->middleware('auth:sanctum');

//get progress revisi by user_id
Route::get('/api-get-progress-revisi', [App\Http\Controllers\Api\ProgressController::class, 'getProgressRevisi'])->middleware('auth:sanctum');

//get progress revisi by pembimbing_id
Route::get('/api-get-progress-revisi-pembimbing', [App\Http\Controllers\Api\ProgressController::class, 'getProgressRevisiPembimbing'])->middleware('auth:sanctum');

//get progress recap by user_id
Route::get('/api-get-progress-recap', [App\Http\Controllers\Api\ProgressController::class, 'getProgressRecap'])->middleware('auth:sanctum');

//update progress/revisi
Route::post('/api-update-progress/{id}', [App\Http\Controllers\Api\ProgressController::class, 'updateProgress'])->middleware('auth:sanctum');

//update peserta approve
Route::post('/api-update-progress-peserta-approve/{id}', [App\Http\Controllers\Api\ProgressController::class, 'updatePesertaApprove'])->middleware('auth:sanctum');

//update pembimbing approve
Route::post('/api-update-progress-pembimbing-approve/{id}', [App\Http\Controllers\Api\ProgressController::class, 'updatePembimbingApprove'])->middleware('auth:sanctum');

//get progress for peserta approve
Route::get('/api-get-progress-peserta-approve', [App\Http\Controllers\Api\ProgressController::class, 'getProgressPesertaApprove'])->middleware('auth:sanctum');

//get progress for pembimbing approve
Route::get('/api-get-progress-pembimbing-approve', [App\Http\Controllers\Api\ProgressController::class, 'getProgressPembimbingApprove'])->middleware('auth:sanctum');