<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WeightController;
use Illuminate\Support\Facades\Route;

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
    Route::post('/profile/pounds', [ProfileController::class, 'pounds'])->name('profile.pounds');
});

Route::resource('weights', WeightController::class)
    ->only(['index', 'store', 'destroy'])
    ->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
