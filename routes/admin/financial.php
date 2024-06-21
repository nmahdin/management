<?php


use App\Http\Controllers\admin\Financial;
use Illuminate\Support\Facades\Route;

// start Transactions
Route::get('/users/list' , [Financial::class , 'users_all'])->name('users.all');
// end Transactions
// start orders
// end orders
// start accounts
// end accounts
// start Transactions
