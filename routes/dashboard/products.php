<?php

use App\Http\Controllers\dashboard\ProductsController;
use Illuminate\Support\Facades\Route;

Route::prefix('/products')->name('products.')->group(function () {

    // start products
    Route::get('/list', [ProductsController::class, 'products_list'])->name('list');
    Route::get('/trash', [ProductsController::class, 'products_trash'])->name('trash');
    Route::get('/create', [ProductsController::class, 'product_create'])->name('create');
    Route::post('/create', [ProductsController::class, 'product_create_post']);
    Route::delete('/delete_picture/{product}', [ProductsController::class, 'product_delete_picture'])->name('delete.picture');
    Route::delete('/delete/{product}', [ProductsController::class, 'product_delete'])->name('delete');
    Route::delete('/trash/d/{id}', [ProductsController::class, 'product_delete_trash'])->name('delete.trash');
    Route::post('/restore/{id}', [ProductsController::class, 'product_restore'])->name('restore');
    Route::get('/edit/{product}', [ProductsController::class, 'product_edit'])->name('edit');
    Route::post('/edit/{product}', [ProductsController::class, 'product_edit_post']);
    Route::get('/detail/{product}', [ProductsController::class, 'product_detail'])->name('detail');
    // categories
    Route::prefix('/categories')->name('categories.')->group(function (){

        Route::get('/list', [ProductsController::class, 'products_categories_list'])->name('list');
        Route::get('/create', [ProductsController::class, 'products_category_create'])->name('create');
        Route::post('/create', [ProductsController::class, 'products_category_create_post']);
        Route::get('/edit/{category}', [ProductsController::class, 'products_category_edit'])->name('edit');
        Route::post('/edit/{category}', [ProductsController::class, 'products_category_edit_post']);
        Route::delete('/delete/{category}', [ProductsController::class, 'products_category_delete'])->name('delete');
        Route::get('/trash', [ProductsController::class, 'products_category_trash'])->name('trash');
        Route::delete('/trash/delete/{id}', [ProductsController::class, 'products_category_trash_d'])->name('delete.trash');
        Route::post('/trash/restore/{id}', [ProductsController::class, 'products_category_trash_restore'])->name('restore');
    });
    // start products statuses
    Route::prefix('/statuses')->name('statuses.')->group(function (){

        Route::get('/list', [ProductsController::class, 'products_statuses_list'])->name('list');
        Route::get('/create', [ProductsController::class, 'products_statuses_create'])->name('create');
        Route::post('/create', [ProductsController::class, 'products_statuses_create_post']);
        Route::get('/edit/{id}', [ProductsController::class, 'products_statuses_edit'])->name('edit');
        Route::post('/edit/{id}', [ProductsController::class, 'products_statuses_edit_post']);
        Route::delete('/delete/{id}', [ProductsController::class, 'products_statuses_delete'])->name('delete');
        Route::delete('/trash/d/{id}', [ProductsController::class, 'products_statuses_trash_delete'])->name('trash.delete');
        Route::post('/trash/r/{id}', [ProductsController::class, 'products_statuses_trash_restore'])->name('trash.restore');
        Route::get('/trash/list', [ProductsController::class, 'products_statuses_trash_list'])->name('trash');
    });




    // end products statuses


});

