<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Semua route yang membutuhkan login harus berada di dalam group ini
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [TransactionController::class, 'index'])->name('dashboard'); // ✅ Sudah dilindungi
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('transactions', TransactionController::class)->only(['create', 'store', 'destroy']);
});

require __DIR__.'/auth.php';