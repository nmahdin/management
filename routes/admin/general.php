<?php


use App\Http\Controllers\admin\General;
use Illuminate\Support\Facades\Route;

// start users
Route::get('/users/list' , [General::class , 'users_all'])->name('users.all');

Route::get('/users/permissions' , [General::class , 'users_permissions'])->name('users.permissions');
Route::get('/users/roles' , [General::class , 'users_roles'])->name('users.roles');

Route::get('/users/roles/creat' , [General::class , 'users_roles_creat'])->name('users.role.creat');
Route::post('/users/roles/creat' , [General::class , 'users_roles_creat_post']);
// end users

// start customers
Route::get('/customers/list' , [General::class , 'customers_list'])->name('customers.list');
Route::get('/customers/creat' , [General::class , 'customers_creat'])->name('customer.creat');
Route::post('/customers/creat' , [General::class , 'customer_create_post']);
Route::delete('/customers/delete/{customer}' , [General::class , 'customers_delete'])->name('customer.delete');
Route::get('/customers/trash/' , [General::class , 'customers_trash'])->name('customer.trash');
Route::post('/customers/restore/{customer}' , [General::class , 'customers_restore'])->name('customer.restore');
Route::delete('/customers/trash/{customer}' , [General::class , 'customers_delete_trash'])->name('customer.delete.trash');
// end customers


// start products
Route::get('/products/list' , [General::class , 'products_list'])->name('products.list');
Route::get('/products/trash' , [General::class , 'products_trash'])->name('products.trash');
Route::get('/products/create' , [General::class , 'product_create'])->name('product.create');
Route::delete('/products/delete/{product}' , [General::class , 'product_delete'])->name('product.delete');
Route::delete('/products/trash/d/{product}' , [General::class , 'product_delete_trash'])->name('product.delete.trash');
Route::post('/products/restore/{product}' , [General::class , 'product_restore'])->name('product.restore');
Route::get('/products/edit/{product}' , [General::class , 'product_edit'])->name('product.edit');
Route::get('/products/detail/{product}' , [General::class , 'product_detail'])->name('product.detail');
// categories
Route::get('/products/categories/list' , [General::class , 'products_categories_list'])->name('products.categories.list');
Route::get('/products/categories/create' , [General::class , 'products_category_create'])->name('products.category.create');
Route::post('/products/categories/create' , [General::class , 'products_category_create_post']);
Route::get('/products/categories/edit/{category}' , [General::class , 'products_category_edit'])->name('products.category.edit');
Route::delete('/products/categories/delete/{category}' , [General::class , 'products_category_delete'])->name('products.category.delete');
Route::get('/products/categories/trash' , [General::class , 'products_category_trash'])->name('products.category.trash');
Route::delete('/products/categories/trash/d/{category}' , [General::class , 'products_category_trash_d'])->name('products.category.delete.trash');
Route::post('/products/categories/trash/re/{category}' , [General::class , 'products_category_trash_restore'])->name('products.category.restore');
// end products
