<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('/');

use App\Http\Controllers\SupplierController;

Route::resource('suppliers', SupplierController::class);


