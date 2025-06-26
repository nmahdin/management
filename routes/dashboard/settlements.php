<?php

use App\Http\Controllers\Dashboard\SettlementController;
use Illuminate\Support\Facades\Route;

Route::prefix('/settlements')->name('settlements.')->group(function () {
    Route::get('/', [SettlementController::class, 'index'])->name('index');
    Route::get('/create', [SettlementController::class, 'create'])->name('create');
    Route::post('/store', [SettlementController::class, 'store'])->name('store');
    Route::get('/{id}', [SettlementController::class, 'show'])->name('show');
});
