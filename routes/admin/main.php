<?php

use App\Http\Controllers\admin\Main;
use Illuminate\Support\Facades\Route;


Route::get('/dashboards/main', [Main::class , 'index'])->name('main');

Route::get('/cart/add/{product}', [Main::class , 'add_to_cart'])->name('cart.add');
Route::get('/cart/list', [Main::class , 'cart_list'])->name('cart.list');
Route::post('/cart/enter', [Main::class , 'enter_order'])->name('cart.enter');
Route::delete('/cart/delete/{id}', [Main::class , 'cart_delete'])->name('cart.delete');

