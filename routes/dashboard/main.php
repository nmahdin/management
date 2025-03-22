<?php


use App\Http\Controllers\dashboard\Main;
use Illuminate\Support\Facades\Route;

Route::get('/dashboards/main', [Main::class , 'index'])->name('main');


Route::prefix('/cart')->name('cart.')->group(function () {
    Route::get('/add/{product}', [Main::class , 'add_to_cart'])->name('add');
    Route::get('/list', [Main::class , 'cart_list'])->name('list');
    Route::post('/enter', [Main::class , 'enter_order'])->name('enter');
    Route::delete('/delete/{id}', [Main::class , 'cart_delete'])->name('delete');
});


// start users
Route::prefix('/users')->name('users.')->group(function () {

    Route::get('/list' , [Main::class , 'users_all'])->name('all');

    Route::get('/permissions' , [Main::class , 'users_permissions'])->name('permissions');
    Route::get('/users/roles' , [Main::class , 'users_roles'])->name('roles');

    Route::get('/roles/creat' , [Main::class , 'users_roles_creat'])->name('role.creat');
    Route::post('/roles/creat' , [Main::class , 'users_roles_creat_post']);
});










require __DIR__.'/customers.php';
require __DIR__.'/products.php';
require __DIR__.'/purchases.php';
require __DIR__.'/transactions.php';
require __DIR__.'/orders.php';
require __DIR__.'/accounts.php';
require __DIR__.'/partners.php';
