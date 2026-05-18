<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;
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

    // Transactions — register export-pdf BEFORE resource to avoid route conflict
    Route::get('/transactions/export-pdf', [TransactionController::class, 'exportPdf'])
        ->name('transactions.export.pdf');
    Route::post('/transactions/analyze-receipt', [TransactionController::class, 'analyzeReceipt'])
        ->name('transactions.analyze.receipt');
    Route::resource('transactions', TransactionController::class)->except(['show']);

    Route::resource('categories', CategoryController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});