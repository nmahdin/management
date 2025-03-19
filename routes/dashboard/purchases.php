<?php


use App\Http\Controllers\dashboard\PurchasesController;
use Illuminate\Support\Facades\Route;

Route::prefix('/purchases')->name('purchases.')->group(function () {

    Route::get('/list', [PurchasesController::class, 'purchases_list'])->name('list');
    Route::get('/create', [PurchasesController::class, 'purchases_create'])->name('create');
    Route::post('/create', [PurchasesController::class, 'purchases_create_post']);
    Route::get('/edit/{purchase}', [PurchasesController::class, 'purchases_edit'])->name('edit');
    Route::post('/edit/{purchase}', [PurchasesController::class, 'purchases_edit_store']);
    Route::delete('/delete/{purchase}', [PurchasesController::class, 'purchases_delete'])->name('delete');
    Route::get('/detail/{purchase}', [PurchasesController::class, 'purchases_detail'])->name('detail');
    Route::get('/trash', [PurchasesController::class, 'purchases_trash'])->name('trash');
    Route::delete('/trash/{purchase}/d', [PurchasesController::class, 'purchases_trash_delete'])->name('delete.trash');
    Route::post('/trash/{purchase}/re', [PurchasesController::class, 'purchases_trash_restore'])->name('restore');


    Route::prefix('/categories')->name('categories.')->group(function () {

        Route::get('/list', [PurchasesController::class, 'purchases_categories_list'])->name('list');
        Route::get('/create', [PurchasesController::class, 'purchases_categories_create'])->name('create');
        Route::post('/create', [PurchasesController::class, 'purchases_categories_create_post']);
        Route::delete('/delete/{purchases_category}', [PurchasesController::class, 'purchases_categories_delete'])->name('delete');
        Route::get('/trash', [PurchasesController::class, 'purchases_categories_trash'])->name('trash');
        Route::delete('/trash/{category}/d', [PurchasesController::class, 'purchases_categories_trash_delete'])->name('delete.trash');
        Route::post('/trash/{category}/re', [PurchasesController::class, 'purchases_categories_trash_restore'])->name('restore');
    });


    Route::prefix('/sellers')->name('sellers.')->group(function () {

        Route::get('/list', [PurchasesController::class, 'sellers_list'])->name('list');
        Route::get('/create', [PurchasesController::class, 'sellers_create'])->name('create');
        Route::post('/create', [PurchasesController::class, 'sellers_create_post']);
        Route::delete('/delete/{seller}', [PurchasesController::class, 'sellers_delete'])->name('delete');
        Route::get('/edit/{seller}', [PurchasesController::class, 'sellers_edit'])->name('edit');
        Route::post('/edit/{seller}', [PurchasesController::class, 'sellers_edit_post']);
        Route::get('/trash', [PurchasesController::class, 'sellers_trash'])->name('trash');
        Route::delete('/trash/{seller}/d', [PurchasesController::class, 'sellers_trash_delete'])->name('trash.delete');
        Route::post('/trash/{seller}/re', [PurchasesController::class, 'sellers_trash_restore'])->name('trash.restore');
    });

});

