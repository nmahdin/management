<?php
use App\Http\Controllers\dashboard\PartnersController;
use Illuminate\Support\Facades\Route;



Route::prefix('/partners')->name('partners.')->group(function () {

    Route::get('/list' , [PartnersController::class , 'partners_list'])->name('list');
    Route::get('/create' , [PartnersController::class , 'partners_create'])->name('create');
    Route::post('/create' , [PartnersController::class , 'partners_create_post']);
    Route::get('/edit/{partner}' , [PartnersController::class , 'partners_edit'])->name('edit');
    Route::post('/edit/{partner}' , [PartnersController::class , 'partners_edit_post']);
    Route::delete('/delete/{partner}' , [PartnersController::class , 'partners_delete'])->name('delete');
    Route::get('/trash' , [PartnersController::class , 'partners_trash_list'])->name('trash');
    Route::delete('/trash/{partner}/d' , [PartnersController::class , 'partners_trash_delete'])->name('trash.d');
    Route::post('/trash/{partner}/re' , [PartnersController::class , 'partners_trash_restore'])->name('trash.r');

});
