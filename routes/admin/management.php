<?php


use App\Http\Controllers\admin\Management;

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
Route::post('/customers/creat' , [Management::class , 'customers_creat_pots']);
Route::delete('/customers/delete/{customer}' , [Management::class , 'customers_delete'])->name('customer.delete');
// end customers
