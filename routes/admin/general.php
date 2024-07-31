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
Route::get('/customers/create' , [General::class , 'customers_create'])->name('customer.creat');
Route::post('/customers/create' , [General::class , 'customer_create_post']);
Route::get('/customers/info/{customer}' , [General::class , 'customer_info'])->name('customer.info');
Route::get('/customers/edit/{customer}' , [General::class , 'customer_edit'])->name('customer.edit');
Route::post('/customers/edit/{customer}' , [General::class , 'customer_edit_post']);
Route::delete('/customers/delete/{customer}' , [General::class , 'customers_delete'])->name('customer.delete');
Route::get('/customers/trash/' , [General::class , 'customers_trash'])->name('customer.trash');
Route::post('/customers/restore/{customer}' , [General::class , 'customers_restore'])->name('customer.restore');
Route::delete('/customers/trash/{customer}' , [General::class , 'customers_delete_trash'])->name('customer.delete.trash');
// end customers


// start products
Route::get('/products/list' , [General::class , 'products_list'])->name('products.list');
Route::get('/products/trash' , [General::class , 'products_trash'])->name('products.trash');
Route::get('/products/create' , [General::class , 'product_create'])->name('product.create');
Route::post('/products/create' , [General::class , 'product_create_post']);
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
Route::post('/products/categories/edit/{category}' , [General::class , 'products_category_edit_post']);
Route::delete('/products/categories/delete/{category}' , [General::class , 'products_category_delete'])->name('products.category.delete');
Route::get('/products/categories/trash' , [General::class , 'products_category_trash'])->name('products.category.trash');
Route::delete('/products/categories/trash/d/{category}' , [General::class , 'products_category_trash_d'])->name('products.category.delete.trash');
Route::post('/products/categories/trash/re/{category}' , [General::class , 'products_category_trash_restore'])->name('products.category.restore');
// end products

// start purchases
Route::get('/purchases/list' , [General::class , 'purchases_list'])->name('purchases.list');
Route::get('/purchases/creat')->name('purchases.creat');
Route::get('/purchases/delete/{purchase}')->name('purchases.delete');
Route::get('/purchases/trash')->name('purchases.trash');
Route::get('/purchases/trash/{purchase}/d')->name('purchases.delete.trash');
Route::get('/purchases/trash/{purchase}/re')->name('purchases.restore');
// categories
Route::get('/purchases/categories/list')->name('purchases.categories.list');
Route::get('/purchases/category/creat')->name('purchases.category.creat');
Route::post('/purchases/category/creat');
Route::get('/purchases/category/delete/{purchase}')->name('purchases.category.delete');
Route::get('/purchases/categories/trash')->name('purchases.categories.trash');
Route::get('/purchases/category/trash/{purchase}/d')->name('purchases.category.delete.trash');
Route::get('/purchases/category/trash/{purchase}/re')->name('purchases.category.restore');
// end purchases
