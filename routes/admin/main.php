<?php

use App\Http\Controllers\admin\Main;
use Illuminate\Support\Facades\Route;


Route::get('/dashboards/main', [Main::class , 'index'])->name('main');
