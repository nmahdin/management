<?php

use App\Http\Controllers\dashboard\OrdersController;
use Illuminate\Support\Facades\Route;


Route::prefix('/orders')->name('orders.')->group(function () {

    Route::get('/list' , [OrdersController::class , 'orders_list'])->name('list');
    Route::get('/create' , [OrdersController::class , 'orders_create'])->name('create');
    Route::post('/create' , [OrdersController::class , 'orders_create_post']);
    Route::get('/edit/{orders}' , [OrdersController::class , 'orders_edit'])->name('edit');
    Route::post('/edit/{orders}' , [OrdersController::class , 'orders_edit_post']);
    Route::delete('/delete/{orders}' , [OrdersController::class , 'orders_delete'])->name('delete');
    Route::get('/trash' , [OrdersController::class , 'orders_trash_list'])->name('trash');
    Route::delete('/trash/{orders}/d' , [OrdersController::class , 'orders_trash_delete'])->name('trash.delete');
    Route::post('/trash/{orders}/re' , [OrdersController::class , 'orders_trash_restore'])->name('trash.restore');

    Route::prefix('/types')->name('types.')->group(function () {
// types
        Route::get('/list', [OrdersController::class, 'orders_types_list'])->name('list');
        Route::get('/create', [OrdersController::class, 'orders_type_create'])->name('create');
        Route::post('/create', [OrdersController::class, 'orders_type_create_post']);
        Route::get('/edit/{type}', [OrdersController::class, 'orders_type_edit'])->name('edit');
        Route::post('/edit/{type}', [OrdersController::class, 'orders_type_edit_post']);
        Route::delete('/delete/{type}', [OrdersController::class, 'orders_type_delete'])->name('delete');
        Route::get('/trash', [OrdersController::class, 'orders_types_trash_list'])->name('trash');
        Route::delete('/trash/{type}/d', [OrdersController::class, 'orders_type_trash_delete'])->name('trash.delete');
        Route::post('/trash/{type}/re', [OrdersController::class, 'orders_type_trash_restore'])->name('trash.restore');

    });

    Route::prefix('/statuses')->name('statuses.')->group(function () {
// statuses
        Route::get('/list', [OrdersController::class, 'orders_statuses_list'])->name('list');
        Route::get('/create', [OrdersController::class, 'orders_statuses_create'])->name('create');
        Route::post('/create', [OrdersController::class, 'orders_statuses_create_post']);
        Route::get('/edit/{statuses}', [OrdersController::class, 'orders_statuses_edit'])->name('edit');
        Route::post('/edit/{statuses}', [OrdersController::class, 'orders_statuses_edit_post']);
        Route::delete('/delete/{statuses}', [OrdersController::class, 'orders_statuses_delete'])->name('delete');
        Route::get('/trash', [OrdersController::class, 'orders_statuses_trash_list'])->name('trash');
        Route::delete('/trash/{statuses}/d', [OrdersController::class, 'orders_statuses_trash_delete'])->name('trash.delete');
        Route::post('/trash/{statuses}/re', [OrdersController::class, 'orders_statuses_trash_restore'])->name('trash.restore');

    });

});

