<?php


use App\Http\Controllers\admin\Financial;
use Illuminate\Support\Facades\Route;

// start Transactions
Route::get('/transactions/list' , [Financial::class , 'transactions_list'])->name('transactions.list');
// end Transactions

// start orders
// end orders

// start accounts
// end accounts

