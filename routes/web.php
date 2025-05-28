<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
//    $test = [
//        'price1' => 120000,
//        'price2' => 150000,
//    ];
//    $test2 = json_encode($test);
////    var_dump($test2);
//    $test3 =  json_decode($test2);
//    var_dump($test3->price1);

//    return $test3['price2'];
//    $product = \App\Models\Product::find(24);
//    return $product;
//    return jdate($product->created_at);
//    return jdate()->now();
//    return view('welcome');
    return redirect(route('main'));
});

//Route::get('/1', [WebController::class, 'index']);

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

require __DIR__.'/auth.php';
Route::middleware('auth')->group(function () {
    require __DIR__.'/dashboard/main.php';
});

