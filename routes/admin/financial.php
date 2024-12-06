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
// types
Route::get('orders/types/list', [Financial::class , 'orders_types_list'])->name('orders.types.list');
Route::get('orders/types/create', [Financial::class , 'orders_type_create'])->name('orders.type.create');
Route::post('orders/types/create', [Financial::class , 'orders_type_create_post']);
Route::get('/orders/types/edit/{type}' , [Financial::class , 'orders_type_edit'])->name('orders.type.edit');
Route::post('/orders/types/edit/{type}' , [Financial::class , 'orders_type_edit_post']);
Route::delete('/orders/types/delete/{type}' , [Financial::class , 'orders_type_delete'])->name('orders.type.delete');
Route::get('/orders/types/trash' , [Financial::class , 'orders_types_trash_list'])->name('orders.types.trash');
Route::delete('/orders/types/trash/{type}/d' , [Financial::class , 'orders_type_trash_delete'])->name('orders.type.trash.delete');
Route::post('/orders/types/trash/{type}/re' , [Financial::class , 'orders_type_trash_restore'])->name('orders.type.trash.restore');
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
Route::get('/partners/edit/{partner}' , [Financial::class , 'partners_edit'])->name('partner.edit');
Route::post('/partners/edit/{partner}' , [Financial::class , 'partners_edit_post']);
Route::delete('/partners/delete/{partner}' , [Financial::class , 'partners_delete'])->name('partner.delete');
Route::get('/partners/trash' , [Financial::class , 'partners_trash_list'])->name('partners.trash');
Route::delete('/partners/trash/{partner}/d' , [Financial::class , 'partners_trash_delete'])->name('partner.trash.d');
Route::post('/partners/trash/{partner}/re' , [Financial::class , 'partners_trash_restore'])->name('partner.trash.r');
// end partners

// start accounts
Route::get('/accounts/list' , [Financial::class , 'accounts_list'])->name('accounts.list');
Route::get('/accounts/create' , [Financial::class , 'accounts_create'])->name('account.create');
Route::post('/accounts/create' , [Financial::class , 'accounts_create_post']);
Route::get('/accounts/edit/{account}' , [Financial::class , 'accounts_edit'])->name('account.edit');
Route::post('/accounts/edit/{account}' , [Financial::class , 'accounts_edit_post']);
Route::delete('/accounts/delete/{account}' , [Financial::class , 'accounts_delete'])->name('account.delete');
Route::get('/accounts/trash' , [Financial::class , 'accounts_trash_list'])->name('accounts.trash');
Route::delete('/accounts/trash/{account}/d' , [Financial::class , 'accounts_trash_delete'])->name('accounts.trash.delete');
Route::post('/accounts/trash/{account}/re' , [Financial::class , 'accounts_trash_restore'])->name('accounts.trash.restore');
// end accounts

