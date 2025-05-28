<?php

use App\Http\Controllers\dashboard\OrdersController;
use Illuminate\Support\Facades\Route;


Route::prefix('/orders')->name('orders.')->group(function () {

    Route::get('/list' , [OrdersController::class , 'orders_list'])->name('list');
    Route::get('/detail/{id}' , [OrdersController::class , 'orders_detail'])->name('detail');
    Route::get('/create' , [OrdersController::class , 'orders_create'])->name('create');
    Route::post('/create' , [OrdersController::class , 'orders_store'])->name('store');
    Route::get('/edit/{orders}' , [OrdersController::class , 'orders_edit'])->name('edit');
    Route::post('/edit/{orders}' , [OrdersController::class , 'orders_edit_post']);
    Route::delete('/delete/{orders}' , [OrdersController::class , 'orders_delete'])->name('delete');
    Route::get('/trash' , [OrdersController::class , 'orders_trash_list'])->name('trash');
    Route::delete('/trash/{orders}/d' , [OrdersController::class , 'orders_trash_delete'])->name('trash.delete');
    Route::post('/trash/{orders}/re' , [OrdersController::class , 'orders_trash_restore'])->name('trash.restore');
    Route::get('/orders/{order}/print', [OrdersController::class, 'printInvoice'])->name('print');


    Route::prefix('/types')->name('types.')->group(function () {
// types
        Route::get('/list', [OrdersController::class, 'orders_types_list'])->name('list');
        Route::get('/create', [OrdersController::class, 'orders_type_create'])->name('create');
        Route::post('/create', [OrdersController::class, 'orders_type_create_post']);
        Route::get('/edit/{id}', [OrdersController::class, 'orders_type_edit'])->name('edit');
        Route::post('/edit/{id}', [OrdersController::class, 'orders_type_edit_post']);
        Route::delete('/delete/{id}', [OrdersController::class, 'orders_type_delete'])->name('delete');
        Route::get('/trash', [OrdersController::class, 'orders_types_trash_list'])->name('trash');
        Route::delete('/trash/{id}/d', [OrdersController::class, 'orders_type_trash_delete'])->name('trash.delete');
        Route::post('/trash/{id}/re', [OrdersController::class, 'orders_type_trash_restore'])->name('trash.restore');

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

Route::patch('/orders/{order}/status/{status}', [OrdersController::class, 'updateStatus'])->name('orders.updateStatus');

