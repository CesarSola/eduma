<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

use function PHPUnit\Framework\callback;

Route::get('/', function () {
    return view('welcome');
});

//
Route::get('/google-auth/redirect', [GoogleController::class, 'redirect'])
    ->name('auth.redirect');

Route::get('/google-auth/callback', [GoogleController::class, 'callback'])
    ->name('auth.callback');


//
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('expedientes', function () {
    return view('expedientes.index');
});
