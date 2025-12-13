<?php

use App\Http\Controllers\MeasurementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WeightController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('weights.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/pounds', [ProfileController::class, 'pounds'])->name('profile.pounds');

    Route::get('/weights/chart', [WeightController::class, 'chart'])->name('weights.chart');
    Route::get('/checkin', [WeightController::class, 'checkin'])->name('weights.checkin');

    Route::get('/measurements', [MeasurementController::class, 'index'])->name('measurements.index');
    Route::post('/measurements/store', [MeasurementController::class, 'store'])->name('measurements.store');
    Route::delete('/measurements/{measurementType}/destroy', [MeasurementController::class, 'destroy'])->name('measurements.destroy');
});

Route::resource('weights', WeightController::class)
    ->only(['index', 'store', 'destroy'])
    ->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
