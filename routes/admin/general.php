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
Route::get('/customers/create' , [General::class , 'customers_create'])->name('customer.create');
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
Route::post('/products/edit/{product}' , [General::class , 'product_edit_post']);
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

// start products statuses
Route::get('/products/statuses/list' , [General::class , 'products_statuses_list'])->name('products.statuses.list');
Route::get('/products/statuses/create' , [General::class , 'products_statuses_create'])->name('products.status.create');
Route::post('/products/statuses/create' , [General::class , 'products_statuses_create_post']);
Route::get('/products/statuses/edit/{status}' , [General::class , 'products_statuses_edit'])->name('products.status.edit');
Route::post('/products/statuses/edit/{status}' , [General::class , 'products_statuses_edit_post']);
Route::delete('/products/statuses/delete/{status}' , [General::class , 'products_statuses_delete'])->name('products.status.delete');
Route::delete('/products/statuses/trash/d/{status}' , [General::class , 'products_statuses_trash_delete'])->name('products.status.trash.d');
Route::post('/products/statuses/trash/r/{status}' , [General::class , 'products_statuses_trash_restore'])->name('products.status.trash.r');
Route::get('/products/statuses/trash/list' , [General::class , 'products_statuses_trash_list'])->name('products.statuses.trash');
// end products statuses

// start purchases
Route::get('/purchases/list' , [General::class , 'purchases_list'])->name('purchases.list');
Route::get('/purchases/create' , [General::class , 'purchases_create'])->name('purchases.create');
Route::post('/purchases/create' , [General::class , 'purchases_create_post']);
Route::get('/purchases/edit/{purchase}' , [General::class , 'purchases_edit'])->name('purchases.edit');
Route::post('/purchases/edit/{purchase}' , [General::class , 'purchases_edit_store']);
Route::delete('/purchases/delete/{purchase}' , [General::class , 'purchases_delete'])->name('purchases.delete');
Route::get('/purchases/detail/{purchase}' , [General::class , 'purchases_detail'])->name('purchases.detail');
Route::get('/purchases/trash' , [General::class , 'purchases_trash'])->name('purchases.trash');
Route::delete('/purchases/trash/{purchase}/d' , [General::class , 'purchases_trash_delete'])->name('purchases.delete.trash');
Route::post('/purchases/trash/{purchase}/re' , [General::class , 'purchases_trash_restore'])->name('purchases.restore');
// categories
Route::get('/purchases/categories/list' , [General::class , 'purchases_categories_list'])->name('purchases.categories.list');
Route::get('/purchases/category/create' , [General::class , 'purchases_categories_create'])->name('purchases.category.create');
Route::post('/purchases/category/create' , [General::class , 'purchases_categories_create_post']);
Route::delete('/purchases/category/delete/{purchases_category}' , [General::class , 'purchases_categories_delete'])->name('purchases.categories.delete');
Route::get('/purchases/categories/trash' , [General::class , 'purchases_categories_trash'])->name('purchases.categories.trash');
Route::delete('/purchases/category/trash/{category}/d' , [General::class , 'purchases_categories_trash_delete'])->name('purchases.categories.delete.trash');
Route::post('/purchases/category/trash/{category}/re' , [General::class , 'purchases_categories_trash_restore'])->name('purchases.categories.restore');
// sellers
Route::get('/purchases/sellers/list' , [General::class , 'sellers_list'])->name('purchases.sellers.list');
Route::get('/purchases/sellers/create' , [General::class , 'sellers_create'])->name('purchases.sellers.create');
Route::post('/purchases/sellers/create' , [General::class , 'sellers_create_post']);
Route::get('/purchases/sellers/delete/{seller}' , [General::class , 'sellers_delete'])->name('purchases.sellers.delete');
Route::get('/purchases/sellers/trash' , [General::class , 'sellers_trash'])->name('purchases.sellers.trash');
Route::get('/purchases/sellers/trash/{seller}/d' , [General::class , 'sellers_trash_delete'])->name('purchases.sellers.trash.delete');
Route::get('/purchases/sellers/trash/{seller}/re' , [General::class , 'sellers_trash_restore'])->name('purchases.sellers.trash.restore');
// end purchases
