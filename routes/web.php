<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\EnrolledController;
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
    Route::get('/enrolled', [EnrolledController::class, 'index'])->name('activity.enrolled');
});
Route::middleware('admin')->controller(ActivityController::class)->group(function () {
  Route::get('/createActivities', 'create')->name('activities.create');
  Route::post('/store', 'store')->name('activities.store');
});

Route::get('/activity/enroll/{activity}', [EnrolledController::class, 'store'])
    ->name('activity.enroll');
Route::delete('/enrolled/{activity}', [EnrolledController::class, 'destroy'])
    ->middleware(['auth', 'verified'])
    ->name('enrolled.destroy');

require __DIR__ . '/auth.php';
