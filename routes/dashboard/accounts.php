<?php

use App\Http\Controllers\dashboard\AccountsController;
use Illuminate\Support\Facades\Route;

Route::prefix('/accounts')->name('accounts.')->group(function () {

    Route::get('/list', [AccountsController::class, 'accounts_list'])->name('list');
    Route::get('/create', [AccountsController::class, 'accounts_create'])->name('create');
    Route::post('/create', [AccountsController::class, 'accounts_create_post']);
    Route::get('/edit/{id}', [AccountsController::class, 'accounts_edit'])->name('edit');
    Route::post('/edit/{id}', [AccountsController::class, 'accounts_edit_post']);
    Route::delete('/delete/{id}', [AccountsController::class, 'accounts_delete'])->name('delete');
    Route::get('/trash', [AccountsController::class, 'accounts_trash_list'])->name('trash');
    Route::delete('/trash/{id}/d', [AccountsController::class, 'accounts_trash_delete'])->name('trash.delete');
    Route::post('/trash/{id}/re', [AccountsController::class, 'accounts_trash_restore'])->name('trash.restore');

});

