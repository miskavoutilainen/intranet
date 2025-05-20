<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TuoteController;
use Illuminate\Support\Facades\Route;

// Kaikki kirjautuneet näkevät tuotteet
Route::middleware(['auth']) 
-> get('/tuotteet', [TuoteController::class, 'index']) 
-> name('tuotteet.index');

// Vain admin voi lisätä, muokata ja poistaa tuotteita
Route::middleware(['auth', 'admin']) -> group(function() {
    Route::resource('tuotteet', TuoteController::class) 
    -> except(['index']) 
    -> parameters([
        'tuotteet' => 'tuote',
    ]);
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})
->middleware(['auth', 'verified'])
->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/tuotteet', [TuoteController::class, 'index'])->name('tuotteet.index');
});

require __DIR__.'/auth.php';
