<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\PatientAuditController;
use App\Http\Controllers\Api\AppointmentController;



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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')->name('login');
});
 
Route::middleware(['auth:sanctum'])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/users', 'users');
        Route::get('/logout', 'logout');
    });

    Route::get('patients/search', [PatientController::class, 'search']);
    Route::apiResource('patients', PatientController::class);

    Route::get('patients/{patient}/audits', [PatientAuditController::class, 'index']);

    Route::get('appointments', [AppointmentController::class, 'index']);
    Route::get('appointments/patient/{patient_id}', [AppointmentController::class, 'by_patient']);
    Route::get('appointments/doctor/{doctor_id}', [AppointmentController::class, 'by_doctor']);
    Route::post('appointments', [AppointmentController::class, 'store']);
    Route::patch('appointments/{appointment_id}', [AppointmentController::class, 'update']);
    Route::delete('appointments/{appointment_id}', [AppointmentController::class, 'destroy']);
});
