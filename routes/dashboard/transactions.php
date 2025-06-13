<?php


use App\Http\Controllers\dashboard\Transactions;
use Illuminate\Support\Facades\Route;


Route::prefix('/transactions')->name('transactions.')->group(function () {

    Route::get('/general' , [Transactions::class , 'transactions_general'])->name('general');
    Route::get('/print', [Transactions::class, 'printTransactions'])->name('print_list');
    Route::get('/{id}', [Transactions::class, 'transactionDetail'])->name('detail');
    Route::delete('/delete/{id}' , [Transactions::class , 'delete_transaction'])->name('delete');
    Route::Get('/new/{type}' , [Transactions::class , 'new_transaction'])->name('new');
    Route::Put('/store/' , [Transactions::class , 'store_transaction'])->name('store');
    Route::get('/{id}/edit', [Transactions::class, 'edit'])->name('edit');
    Route::put('/{id}/update', [Transactions::class, 'update'])->name('update');
    Route::put('/{id}', [Transactions::class, 'pay'])->name('pay');
    Route::get('/{id}/print', [Transactions::class, 'print'])->name('print');

    Route::prefix('/inputs')->name('inputs.')->group(function () {

        Route::get('/index' , [Transactions::class , 'transactions_inputs'])->name('index');
        Route::get('/new' , [Transactions::class , 'transactions_inputs_new'])->name('new');
        Route::post('/new' , [Transactions::class , 'transactions_inputs_new_post']);
        Route::get('/edit/{input}/' , [Transactions::class , 'transactions_inputs_edit'])->name('edit');
        Route::post('/edit/{input}/' , [Transactions::class , 'transactions_inputs_edit_post']);
        Route::delete('/delete/{input}/' , [Transactions::class , 'transactions_inputs_delete'])->name('delete');
        Route::get('/trash/' , [Transactions::class , 'transactions_inputs_trash_list'])->name('trash');
        Route::delete('/trash/delete/{input}/' , [Transactions::class , 'transactions_inputs_trash_delete'])->name('trash');
        Route::post('/trash/restore/{input}/' , [Transactions::class , 'transactions_inputs_trash_restore'])->name('trash');
    });

    Route::prefix('/outputs')->name('outputs.')->group(function () {

        Route::get('/index' , [Transactions::class , 'transactions_outputs'])->name('index');
        Route::get('/new' , [Transactions::class , 'transactions_outputs_new'])->name('.new');
        Route::post('/new' , [Transactions::class , 'transactions_outputs_new_post']);
        Route::delete('/delete/{output}/' , [Transactions::class , 'transactions_outputs_delete'])->name('delete');
        Route::get('/edit/{output}/' , [Transactions::class , 'transactions_outputs_edit'])->name('edit');
        Route::post('/edit/{output}/' , [Transactions::class , 'transactions_outputs_edit_post']);
        Route::get('/trash/' , [Transactions::class , 'transactions_outputs_trash_list'])->name('trash');
        Route::delete('/trash/delete/{output}/' , [Transactions::class , 'transactions_outputs_trash_delete'])->name('trash');
        Route::post('/trash/restore/{output}/' , [Transactions::class , 'transactions_outputs_trash_restore'])->name('trash');
    });

    Route::prefix('/labels')->name('labels.')->group(function () {
        Route::get('/index', [Transactions::class, 'labels_index'])->name('index');
        Route::get('/new', [Transactions::class, 'labels_new'])->name('create');
        Route::post('/new', [Transactions::class, 'labels_new_post']);
        Route::get('/edit/{label}', [Transactions::class, 'labels_edit'])->name('edit');
        Route::post('/edit/{label}', [Transactions::class, 'labels_edit_post']);
        Route::delete('/delete/{label}', [Transactions::class, 'labels_delete'])->name('delete');
        Route::get('/trash', [Transactions::class, 'labels_trash_list'])->name('trash');
        Route::post('/trash/restore/{id}', [Transactions::class, 'labels_trash_restore'])->name('trash.restore');
        Route::delete('/trash/delete/{id}', [Transactions::class, 'labels_trash_delete'])->name('trash.delete');
    });
});
