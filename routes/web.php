<?php

use App\Http\Controllers\KategoriaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TuoteController;
use App\Models\Kategoria;
use Illuminate\Support\Facades\Route;

// --------- VAIN ADMIN NÄKEE ---------
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('tuotteet', TuoteController::class)
        ->except(['index'])
        ->parameters([
            'tuotteet' => 'tuote',
        ]);
    Route::resource('kategoriat', KategoriaController::class)
        ->except(['index'])
        ->parameters([
            'kategoriat' => 'kategoria',
        ]);
});

// --------- KAIKKI NÄKEE ---------
Route::get('/', function () {
    return view('welcome');
});

// --------- KAIKKI KIRJAUTUNEET NÄKEE ---------
Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// --------- KAIKKI KIRJAUTUNEET NÄKEE ---------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/tuotteet', [TuoteController::class, 'index'])->name('tuotteet.index');
    Route::get('/kategoriat', [KategoriaController::class, 'index'])->name('kategoriat.index');
});

require __DIR__ . '/auth.php';
