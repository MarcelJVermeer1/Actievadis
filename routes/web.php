<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\EnrolledController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\GuestEnrollmentController;


Route::get('/', [ActivityController::class, 'getActivitiesList'])->name('welcome');

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
    Route::get('/activities/{id}/edit', 'edit')->name('activities.edit');
    Route::put('/activities/{id}', 'update')->name('activities.update');
});
Route::middleware('auth')->controller(EnrolledController::class)->group(function () {
    Route::get('/activity/enroll/{activity}', 'store')->name('activity.enroll');
    Route::get('/enrolled/{activity}', 'destroy')->name('enrolled.destroy');
});
Route::post('/guest-enrollment', [GuestEnrollmentController::class, 'store'])->name('guest.enrollment.store');
require __DIR__ . '/auth.php';
