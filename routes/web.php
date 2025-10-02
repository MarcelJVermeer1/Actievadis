<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\EnrolledController;
use App\Http\Controllers\UserManagementController;

// Home
Route::get('/', [ActivityController::class, 'index'])->name('home');
// User management (alleen admin)
Route::get('/usermanagement', [UserManagementController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('usermanagement');

Route::delete('/usermanagement/{user}', [UserManagementController::class, 'destroy'])
    ->middleware(['auth', 'verified'])
    ->name('usermanagement.destroy');

// Profile routes (alleen ingelogd)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Activities (resource routes)
Route::middleware('auth')->group(function () {
    Route::resource('/activity', ActivityController::class)->names('activity');
    Route::get('/enrolled', [EnrolledController::class, 'index'])->name('activity.enrolled');
});

// Activities management (admin only)
Route::middleware('admin')->controller(ActivityController::class)->group(function () {
    Route::get('/createActivities', 'create')->name('activities.create');
    Route::post('/store', 'store')->name('activities.store');
});

// Enrollments (users & guests)
Route::middleware('auth')->group(function () {
    // User inschrijven
    Route::post('/activity/{activity}/enroll', [EnrolledController::class, 'store'])
        ->name('activity.enroll');

    // User uitschrijven
    Route::delete('/activity/{activity}/enroll', [EnrolledController::class, 'destroy'])
        ->name('activity.unenroll');
});

// Guest inschrijvingen (geen login verplicht)
Route::post('/activity/{activity}/guest-enroll', [EnrolledController::class, 'storeGuest'])
    ->name('activity.guest.enroll');

Route::delete('/activity/{activity}/guest-enroll', [EnrolledController::class, 'destroyGuest'])
    ->name('activity.guest.unenroll');

// Auth routes (Breeze/Jetstream)
require __DIR__ . '/auth.php';
