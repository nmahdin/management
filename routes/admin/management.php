<?php


use App\Http\Controllers\admin\Management;
use Illuminate\Support\Facades\Route;

// start users
Route::get('/users/list' , [Management::class , 'users_all'])->name('users.all');

Route::get('/users/permissions' , [Management::class , 'users_permissions'])->name('users.permissions');
Route::get('/users/roles' , [Management::class , 'users_roles'])->name('users.roles');

Route::get('/users/roles/creat' , [Management::class , 'users_roles_creat'])->name('users.role.creat');
Route::post('/users/roles/creat' , [Management::class , 'users_roles_creat_post']);
// end users

// start customers
Route::get('/customers/list' , [Management::class , 'customers_list'])->name('customers.list');
Route::get('/customers/creat' , [Management::class , 'customers_creat'])->name('customer.creat');
Route::post('/customers/creat' , [Management::class , 'customer_create_post']);
Route::delete('/customers/delete/{customer}' , [Management::class , 'customers_delete'])->name('customer.delete');
Route::get('/customers/trash/' , [Management::class , 'customers_trash'])->name('customer.trash');
Route::post('/customers/restore/{customer}' , [Management::class , 'customers_restore'])->name('customer.restore');
Route::delete('/customers/trash/{customer}' , [Management::class , 'customers_delete_trash'])->name('customer.delete.trash');
// end customers


// start products
Route::get('/products/list' , [Management::class , 'products_list'])->name('products.list');
Route::get('/products/trash' , [Management::class , 'products_trash'])->name('products.trash');
Route::get('/products/create' , [Management::class , 'product_create'])->name('product.create');
Route::delete('/products/delete/{product}' , [Management::class , 'product_delete'])->name('product.delete');
Route::get('/products/edit/{product}' , [Management::class , 'product_edit'])->name('product.edit');
Route::get('/products/detail/{product}' , [Management::class , 'product_detail'])->name('product.detail');
Route::get('/products/categories/list' , [Management::class , 'products_categories_list'])->name('products.categories.list');
Route::get('/products/categories/create' , [Management::class , 'products_category_create'])->name('products.category.create');
Route::get('/products/categories/edit/{category}' , [Management::class , 'products_category_edit'])->name('products.category.edit');
Route::get('/products/categories/delete/{category}' , [Management::class , 'products_category_delete'])->name('products.category.delete');
// end products
