<?php


use App\Http\Controllers\admin\Financial;
use Illuminate\Support\Facades\Route;

// start Transactions
Route::get('/transactions/general' , [Financial::class , 'transactions_general'])->name('transactions.general');
Route::get('/transactions/inputs' , [Financial::class , 'transactions_inputs'])->name('transactions.inputs');
Route::get('/transactions/inputs/new' , [Financial::class , 'transactions_inputs_new'])->name('transactions.inputs.new');
Route::post('/transactions/inputs/new' , [Financial::class , 'transactions_inputs_new_post']);
Route::get('/transactions/inputs/edit/{input}/' , [Financial::class , 'transactions_inputs_edit'])->name('transactions.input.edit');
Route::post('/transactions/inputs/edit/{input}/' , [Financial::class , 'transactions_inputs_edit_post']);
Route::delete('/transactions/inputs/delete/{input}/' , [Financial::class , 'transactions_inputs_delete'])->name('transactions.input.delete');
Route::get('/transactions/inputs/trash/' , [Financial::class , 'transactions_inputs_trash_list'])->name('transactions.inputs.trash');
Route::delete('/transactions/inputs/trash/delete/{input}/' , [Financial::class , 'transactions_inputs_trash_delete'])->name('transactions.inputs.trash');
Route::post('/transactions/inputs/trash/restore/{input}/' , [Financial::class , 'transactions_inputs_trash_restore'])->name('transactions.inputs.trash');
Route::get('/transactions/outputs' , [Financial::class , 'transactions_outputs'])->name('transactions.outputs');
Route::get('/transactions/outputs/new' , [Financial::class , 'transactions_outputs_new'])->name('transactions.outputs.new');
Route::post('/transactions/outputs/new' , [Financial::class , 'transactions_outputs_new_post']);
Route::delete('/transactions/outputs/delete/{output}/' , [Financial::class , 'transactions_outputs_delete'])->name('transactions.output.delete');
Route::get('/transactions/outputs/edit/{output}/' , [Financial::class , 'transactions_outputs_edit'])->name('transactions.output.edit');
Route::post('/transactions/outputs/edit/{output}/' , [Financial::class , 'transactions_outputs_edit_post']);
Route::get('/transactions/outputs/trash/' , [Financial::class , 'transactions_outputs_trash_list'])->name('transactions.inputs.trash');
Route::delete('/transactions/outputs/trash/delete/{output}/' , [Financial::class , 'transactions_outputs_trash_delete'])->name('transactions.inputs.trash');
Route::post('/transactions/outputs/trash/restore/{output}/' , [Financial::class , 'transactions_outputs_trash_restore'])->name('transactions.inputs.trash');
// end Transactions

// start orders
Route::get('/orders/list' , [Financial::class , 'orders_list'])->name('orders.list');
Route::get('/orders/create' , [Financial::class , 'orders_create'])->name('orders.create');
Route::post('/orders/create' , [Financial::class , 'orders_create_post']);
Route::get('/orders/edit/{orders}' , [Financial::class , 'orders_edit'])->name('orders.edit');
Route::post('/orders/edit/{orders}' , [Financial::class , 'orders_edit_post']);
Route::delete('/orders/delete/{orders}' , [Financial::class , 'orders_delete'])->name('orders.delete');
Route::get('/orders/trash' , [Financial::class , 'orders_trash_list'])->name('orders.trash');
Route::delete('/orders/trash/{orders}/d' , [Financial::class , 'orders_trash_delete'])->name('orders.trash.delete');
Route::post('/orders/trash/{orders}/re' , [Financial::class , 'orders_trash_restore'])->name('orders.trash.restore');
// categories
Route::get('orders/categories/list', [Financial::class , 'orders_categories_list'])->name('orders.categories.list');
Route::get('orders/categories/create', [Financial::class , 'orders_categories_create'])->name('orders.categories.create');
Route::post('orders/categories/create', [Financial::class , 'orders_categories_create_post']);
Route::get('/orders/categories/edit/{categories}' , [Financial::class , 'orders_categories_edit'])->name('orders.categories.edit');
Route::post('/orders/categories/edit/{categories}' , [Financial::class , 'orders_categories_edit_post']);
Route::delete('/orders/categories/delete/{categories}' , [Financial::class , 'orders_categories_delete'])->name('orders.categories.delete');
Route::get('/orders/categories/trash' , [Financial::class , 'orders_categories_trash_list'])->name('orders.categories.trash');
Route::delete('/orders/categories/trash/{categories}/d' , [Financial::class , 'orders_categories_trash_delete'])->name('orders.categories.trash.delete');
Route::post('/orders/categories/trash/{categories}/re' , [Financial::class , 'orders_categories_trash_restore'])->name('orders.categories.trash.restore');
// statuses
Route::get('/orders/statuses/list', [Financial::class , 'orders_statuses_list'])->name('orders.statuses.list');
Route::get('/orders/statuses/create', [Financial::class , 'orders_statuses_create'])->name('orders.statuses.create');
Route::post('/orders/statuses/create', [Financial::class , 'orders_statuses_create_post']);
Route::get('/orders/statuses/edit/{statuses}' , [Financial::class , 'orders_statuses_edit'])->name('orders.statuses.edit');
Route::post('/orders/statuses/edit/{statuses}' , [Financial::class , 'orders_statuses_edit_post']);
Route::delete('/orders/statuses/delete/{statuses}' , [Financial::class , 'orders_statuses_delete'])->name('orders.statuses.delete');
Route::get('/orders/statuses/trash' , [Financial::class , 'orders_statuses_trash_list'])->name('orders.statuses.trash');
Route::delete('/orders/statuses/trash/{statuses}/d' , [Financial::class , 'orders_statuses_trash_delete'])->name('orders.statuses.trash.delete');
Route::post('/orders/statuses/trash/{statuses}/re' , [Financial::class , 'orders_statuses_trash_restore'])->name('orders.statuses.trash.restore');
// end orders

// start partners
Route::get('/partners/list' , [Financial::class , 'partners_list'])->name('partners.list');
Route::get('/partners/create' , [Financial::class , 'partners_create'])->name('partners.create');
Route::post('/partners/create' , [Financial::class , 'partners_create_post']);
Route::get('/partners/edit/{partners}' , [Financial::class , 'partners_edit'])->name('partners.edit');
Route::post('/partners/edit/{partners}' , [Financial::class , 'partners_edit_post']);
Route::delete('/partners/delete/{partners}' , [Financial::class , 'partners_delete'])->name('partners.delete');
Route::get('/partners/trash' , [Financial::class , 'partners_trash_list'])->name('partners.trash');
Route::delete('/partners/trash/{partners}/d' , [Financial::class , 'partners_trash_delete'])->name('partners.trash.delete');
Route::post('/partners/trash/{partners}/re' , [Financial::class , 'partners_trash_restore'])->name('partners.trash.restore');
// end partners

// start accounts
Route::get('/accounts/list' , [Financial::class , 'accounts_list'])->name('accounts.list');
Route::get('/accounts/create' , [Financial::class , 'accounts_create'])->name('accounts.create');
Route::post('/accounts/create' , [Financial::class , 'accounts_create_post']);
Route::get('/accounts/edit/{accounts}' , [Financial::class , 'accounts_edit'])->name('accounts.edit');
Route::post('/accounts/edit/{accounts}' , [Financial::class , 'accounts_edit_post']);
Route::get('/accounts/delete/{accounts}' , [Financial::class , 'accounts_delete'])->name('accounts.delete');
Route::get('/accounts/trash' , [Financial::class , 'accounts_trash_list'])->name('accounts.trash');
Route::delete('/accounts/trash/{accounts}/d' , [Financial::class , 'accounts_trash_delete'])->name('accounts.trash.delete');
Route::post('/accounts/trash/{accounts}/re' , [Financial::class , 'accounts_trash_restore'])->name('accounts.trash.restore');
// end accounts

