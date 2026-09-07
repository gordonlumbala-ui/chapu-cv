<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.manage');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/dashboard', function () {
        return match (strtolower((string) Auth::user()->role)) {
            'admin' => view('Admin.dashboard'),
            'client' => view('client.dashboard'),
            default => view('guest.dashboard'),
        };
    })->name('dashboard');
});