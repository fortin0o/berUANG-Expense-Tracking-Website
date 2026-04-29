<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FrameController;
use Illuminate\Support\Facades\Route;

// Landing Page (bisa diakses semua orang)
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Routes Breeze (auth)
require __DIR__.'/auth.php';

// Routes yang membutuhkan autentikasi
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('transactions', TransactionController::class)
    ->except(['show']);
    Route::resource('categories', CategoryController::class);
    Route::get('/frame', [FrameController::class, 'index'])->name('frame');
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::resource('transactions', \App\Http\Controllers\TransactionController::class)
    ->except(['show']);
    Route::post('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/transactions/export-pdf', [TransactionController::class, 'exportPdf'])
    ->name('transactions.export.pdf');
});