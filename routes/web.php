<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QcController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/stats', [DashboardController::class, 'stats'])->name('dashboard.stats');

    Route::prefix('qc')->name('qc.')->group(function () {
        Route::get('upload', [QcController::class, 'upload'])->name('upload')->middleware('permission:qc.upload');
        Route::post('upload', [QcController::class, 'processUpload'])->name('processUpload')->middleware('permission:qc.upload');
        Route::get('manual', [QcController::class, 'manual'])->name('manual')->middleware('permission:qc.manual');
        Route::post('manual', [QcController::class, 'storeManual'])->name('storeManual')->middleware('permission:qc.manual');
        Route::get('history', [QcController::class, 'history'])->name('history')->middleware('permission:qc.history');
    });

    Route::resource('products', ProductController::class)->middleware('permission:products.index');
    // Route::resource('users', UserController::class)->except(['create', 'show', 'edit'])->middleware('permission:users.index');

    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', [InventoryController::class, 'index'])->name('index')->middleware('permission:inventory.index');
        Route::get('mutations', [InventoryController::class, 'mutations'])->name('mutations')->middleware('permission:inventory.mutations');
        Route::post('adjust/{id}', [InventoryController::class, 'adjustStock'])->name('adjust')->middleware('permission:inventory.index');
    });

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index')->middleware('permission:reports.index');
        Route::post('qc', [ReportController::class, 'generateQc'])->name('generateQc')->middleware('permission:reports.index');
        Route::post('inventory', [ReportController::class, 'generateInventory'])->name('generateInventory')->middleware('permission:reports.index');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
