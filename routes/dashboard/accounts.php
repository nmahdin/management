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

    // trashed
    Route::get('/trash', [AccountsController::class, 'accounts_trash_list'])->name('trash');
    Route::delete('/trash/{id}/d', [AccountsController::class, 'accounts_trash_delete'])->name('trash.delete');
    Route::post('/trash/{id}/re', [AccountsController::class, 'accounts_trash_restore'])->name('trash.restore');

    // reports (use route-model-binding -> {account} to pass Accounts $account to controller)
    Route::get('/reports', [AccountsController::class, 'reports'])->name('index');

    // show report for a specific account (filters are passed as query params)
    Route::get('/{account}/report', [AccountsController::class, 'showReport'])->name('report');

    // download report (format=csv|pdf via query param)
    Route::get('/{account}/report/download', [AccountsController::class, 'downloadReport'])->name('report.download');

    // optional: chart endpoint for ajax chart data
    Route::get('/{account}/chart', [AccountsController::class, 'showChart'])->name('chart');
});

