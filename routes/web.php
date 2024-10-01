<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CarController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::resource('cars', CarController::class);
});

use App\Http\Controllers\Admin\RentalController;

Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::resource('rentals', RentalController::class)->only(['index', 'show', 'destroy']);
});

use App\Http\Controllers\Admin\CustomerController;

Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::resource('customers', CustomerController::class);
});

use App\Http\Controllers\Admin\DashboardController;

Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});




require __DIR__.'/auth.php';
