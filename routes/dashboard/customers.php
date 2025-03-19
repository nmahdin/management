<?php

use App\Http\Controllers\dashboard\CustomersController;
use Illuminate\Support\Facades\Route;

// start customers
Route::prefix('/customers')->name('customers.')->group(function () {
    Route::get('/list', [CustomersController::class, 'customers_list'])->name('list');
    Route::get('/create', [CustomersController::class, 'customers_create'])->name('create');
    Route::post('/create', [CustomersController::class, 'customer_create_post']);
    Route::get('/info/{customer}', [CustomersController::class, 'customer_info'])->name('info');
    Route::get('/edit/{customer}', [CustomersController::class, 'customer_edit'])->name('edit');
    Route::post('/edit/{customer}', [CustomersController::class, 'customer_edit_post']);
    Route::delete('/delete/{customer}', [CustomersController::class, 'customers_delete'])->name('delete');
    Route::get('/trash/', [CustomersController::class, 'customers_trash'])->name('trash');
    Route::post('/restore/{id}', [CustomersController::class, 'customers_restore'])->name('restore');
    Route::delete('/trash/{id}', [CustomersController::class, 'customers_forceDelete'])->name('delete.trash');
    Route::get('/categories/list', [CustomersController::class, 'customers_category_list'])->name('categories.list');
    Route::get('/categories/create', [CustomersController::class, 'customers_category_create'])->name('categories.create');
    Route::post('/categories/create', [CustomersController::class, 'customers_category_store']);
    Route::get('/categories/edit/{id}', [CustomersController::class, 'customers_category_edit'])->name('categories.edit');
    Route::post('/categories/edit/{id}', [CustomersController::class, 'customers_category_update']);
    Route::delete('/categories/delete/{id}', [CustomersController::class, 'customers_category_delete'])->name('categories.delete');
    Route::get('/categories/trash', [CustomersController::class, 'customers_category_trash'])->name('categories.trash');
    Route::post('/trash/restore/{id}', [CustomersController::class, 'customers_category_restore'])->name('categories.trash.restore');
    Route::delete('/trash/delete/{id}', [CustomersController::class, 'customers_category_forceDelete'])->name('categories.trash.delete');
});
// end customers
