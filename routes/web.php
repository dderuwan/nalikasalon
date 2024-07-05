<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('dashboard.index');
// });

Auth::routes();

 Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('/');

// supplier module

 Route::get('/allsupplier', [App\Http\Controllers\SupplierController::class,'index'])->name('allsupplier');
 Route::get('/createsupplier',[App\Http\Controllers\SupplierController::class,'create'])->name('createsupplier');
 Route::post('/insertsupplier', [App\Http\Controllers\SupplierController::class,'store'])->name('insertsupplier');
 Route::get('/editsupplier/{id}', [App\Http\Controllers\SupplierController::class,'edit'])->name('editsupplier');
 Route::get('/showsupplier/{id}', [App\Http\Controllers\SupplierController::class,'show'])->name('showsupplier');
 Route::put('/updatesupplier', [App\Http\Controllers\SupplierController::class,'update'])->name('updatesupplier');
 Route::delete('/deletesupplier/{id}',[App\Http\Controllers\SupplierController::class,'destroy'])->name('deletesupplier');

 // Item module routes
 Route::get('/allitems', [App\Http\Controllers\ItemController::class, 'index'])->name('allitems');
 Route::get('/createitem', [App\Http\Controllers\ItemController::class, 'create'])->name('createitem');
 Route::post('/insertitem', [App\Http\Controllers\ItemController::class, 'store'])->name('insertitem');
 Route::get('/edititem/{id}', [App\Http\Controllers\ItemController::class, 'edit'])->name('edititem');
 Route::get('/showitem/{id}', [App\Http\Controllers\ItemController::class, 'show'])->name('showitem');
 Route::put('/updateitem/{id}', [App\Http\Controllers\ItemController::class, 'update'])->name('updateitem');
 Route::delete('/deleteitem/{id}', [App\Http\Controllers\ItemController::class, 'destroy'])->name('deleteitem');
 Route::get('/masterstock', [App\Http\Controllers\ItemController::class, 'showMasterStock'])->name('masterstock');

 //Customer
 Route::get('/allcustomer', [App\Http\Controllers\CustomerController::class, 'index'])->name('allcustomer');
 Route::get('/createcustomer', [App\Http\Controllers\CustomerController::class, 'create'])->name('createcustomer');
 Route::post('/insertcustomer', [App\Http\Controllers\CustomerController::class, 'store'])->name('insertcustomer');
 Route::get('/editcustomer/{id}', [App\Http\Controllers\CustomerController::class, 'edit'])->name('editcustomer');
 Route::get('/showcustomer/{id}', [App\Http\Controllers\CustomerController::class, 'show'])->name('showcustomer');
 Route::put('/updatecustomer/{id}', [App\Http\Controllers\CustomerController::class, 'update'])->name('updatecustomer');
 Route::delete('/deletecustomer/{id}', [App\Http\Controllers\CustomerController::class, 'destroy'])->name('deletecustomer');



