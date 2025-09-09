<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\UserManagementController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/usermanagement', [UserManagementController::class, 'index'])->middleware(['auth', 'verified'])->name('usermanagement');
Route::delete('/usermanagement/{user}', [UserManagementController::class, 'destroy'])->middleware(['auth', 'verified'])->name('usermanagement.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('auth')->group(function () {
    Route::resource('/activity', ActivityController::class)->names('activity');
});

require __DIR__ . '/auth.php';
