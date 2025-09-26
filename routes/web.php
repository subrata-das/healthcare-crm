<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterUserRole;

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
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     // return auth()->user()->getRoleNames();
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::middleware(['role:Admin'])->patch('/role/update', [RegisterUserRole::class, 'update'])->name('role.update');
    Route::middleware(['role:Doctor'])->put('/profession/update', [ProfileController::class, 'updateProfession'])->name('profession.update');
});


Route::middleware(['auth:sanctum', 'role:Admin'])->get('/admin/dashboard', function () {
    return view('dashboard');
})->name('dashboard.admin');
Route::middleware(['auth:sanctum', 'role:CRM Agent'])->get('/crm/dashboard', function () {
    return view('dashboard');
})->name('dashboard.crm');
Route::middleware(['auth:sanctum', 'role:Doctor'])->get('/doctor/dashboard', function () {
    return view('dashboard');
})->name('dashboard.doctor');
Route::middleware(['auth:sanctum', 'role:Patient'])->get('/patient/dashboard', function () {
    return view('dashboard');
})->name('dashboard.patient');
Route::middleware(['auth:sanctum', 'role:Lab Manager'])->get('/lab/dashboard', function () {
    return view('dashboard');
})->name('dashboard.lab_manager');

require __DIR__.'/auth.php';
