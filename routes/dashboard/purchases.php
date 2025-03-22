<?php


use App\Http\Controllers\dashboard\PurchasesController;
use Illuminate\Support\Facades\Route;

Route::prefix('/purchases')->name('purchases.')->group(function () {

    Route::get('/list', [PurchasesController::class, 'purchases_list'])->name('list');
    Route::get('/create', [PurchasesController::class, 'purchases_create'])->name('create');
    Route::post('/create', [PurchasesController::class, 'purchases_create_post']);
    Route::get('/edit/{id}', [PurchasesController::class, 'purchases_edit'])->name('edit');
    Route::post('/edit/{id}', [PurchasesController::class, 'purchases_edit_store']);
    Route::delete('/delete/{id}', [PurchasesController::class, 'purchases_delete'])->name('delete');
    Route::get('/detail/{id}', [PurchasesController::class, 'purchases_detail'])->name('detail');
    Route::get('/trash', [PurchasesController::class, 'purchases_trash'])->name('trash');
    Route::delete('/delete/picture/{id}', [PurchasesController::class, 'purchases_delete_picture'])->name('delete.picture');
    Route::delete('/trash/{id}/d', [PurchasesController::class, 'purchases_trash_delete'])->name('delete.trash');
    Route::post('/trash/{id}/re', [PurchasesController::class, 'purchases_trash_restore'])->name('restore');


    Route::prefix('/categories')->name('categories.')->group(function () {

        Route::get('/list', [PurchasesController::class, 'purchases_categories_list'])->name('list');
        Route::get('/create', [PurchasesController::class, 'purchases_categories_create'])->name('create');
        Route::post('/create', [PurchasesController::class, 'purchases_categories_create_post']);
        Route::get('/edit/{id}', [PurchasesController::class, 'purchases_categories_edit'])->name('edit');
        Route::post('/edit/{id}', [PurchasesController::class, 'purchases_categories_update']);
        Route::delete('/delete/{id}', [PurchasesController::class, 'purchases_categories_delete'])->name('delete');
        Route::get('/trash', [PurchasesController::class, 'purchases_categories_trash'])->name('trash');
        Route::delete('/trash/{id}/d', [PurchasesController::class, 'purchases_categories_trash_delete'])->name('delete.trash');
        Route::post('/trash/{id}/re', [PurchasesController::class, 'purchases_categories_trash_restore'])->name('restore');
    });


    Route::prefix('/sellers')->name('sellers.')->group(function () {

        Route::get('/list', [PurchasesController::class, 'sellers_list'])->name('list');
        Route::get('/create', [PurchasesController::class, 'sellers_create'])->name('create');
        Route::post('/create', [PurchasesController::class, 'sellers_create_post']);
        Route::delete('/delete/{id}', [PurchasesController::class, 'sellers_delete'])->name('delete');
        Route::get('/edit/{id}', [PurchasesController::class, 'sellers_edit'])->name('edit');
        Route::post('/edit/{id}', [PurchasesController::class, 'sellers_edit_post']);
        Route::get('/trash', [PurchasesController::class, 'sellers_trash'])->name('trash');
        Route::delete('/trash/{id}/d', [PurchasesController::class, 'sellers_trash_delete'])->name('trash.delete');
        Route::post('/trash/{id}/re', [PurchasesController::class, 'sellers_trash_restore'])->name('trash.restore');
    });

});

