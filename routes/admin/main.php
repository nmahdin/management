<?php

use App\Http\Controllers\admin\Main;


Route::get('/dashboards/main', [Main::class , 'index'])->name('main');
