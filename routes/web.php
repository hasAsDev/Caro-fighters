<?php

use App\Http\Controllers\BattleController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BattlegroundController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\RegisteredUserController;

// welcome
Route::get('/', function () {
    return view('welcome');
})->name('welcome');


// guest
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

});


// auth
Route::middleware('auth')->group(function () {
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

// dashboard
Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('ranking', [DashboardController::class, 'showranking'])->name('ranking');
    Route::post('searchbattleground', [DashboardController::class, 'searchbattleground'])
        ->name('searchbattleground');
});

// profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// battle
Route::middleware('auth')->group(function () {
    Route::get('/battle', [BattleController::class, 'show'])->name('battle');
    Route::put('/battle', [BattleController::class, 'battle']);

    Route::get('/battleground/{battleground_id}', [BattlegroundController::class, 'show']);
});

//api
Route::middleware('auth')->group(function () {
    Route::get('/api/battleground/{battleground_id}', [BattlegroundController::class, 'index']);
    Route::post('/api/battleground/{battleground_id}', [BattlegroundController::class, 'update']);
    Route::patch('/api/battleground/{battleground_id}', [BattlegroundController::class, 'timeout']);
});