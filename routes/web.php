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


 //POS
Route::get('/pospage', [App\Http\Controllers\POSController::class, 'showHomepage'])->name('pospage');
Route::post('/POS.store', [App\Http\Controllers\POSController::class, 'store'])->name('POS.store');
Route::post('/POS.customerstore', [App\Http\Controllers\POSController::class, 'customerstore'])->name('POS.customerstore');
Route::get('/showpos/{id}', [App\Http\Controllers\POSController::class, 'show'])->name('showopos');
Route::delete('/deletepos/{id}', [App\Http\Controllers\POSController::class, 'destroy'])->name('deletepos');

// OrderRequest module
Route::get('/allorderrequests', [App\Http\Controllers\RequestOrderContraller::class, 'index'])->name('allorderrequests');
Route::get('/createorderrequests', [App\Http\Controllers\RequestOrderContraller::class, 'create'])->name('orderrequests.create');
Route::post('/insertorderrequests', [App\Http\Controllers\RequestOrderContraller::class, 'store'])->name('orderrequests.store'); 
Route::get('/showorderrequests/{id}', [App\Http\Controllers\RequestOrderContraller::class, 'show'])->name('orderrequests.show');
Route::get('/editorderrequests/{id}/edit', [App\Http\Controllers\RequestOrderContraller::class, 'edit'])->name('orderrequests.edit');
Route::put('/updateorderrequests/{id}', [App\Http\Controllers\RequestOrderContraller::class, 'update'])->name('orderrequests.update');
Route::delete('/deleteorderrequests/{id}', [App\Http\Controllers\RequestOrderContraller::class, 'destroy'])->name('orderrequests.destroy');

// API Routes for fetching items and stock
Route::get('/api/get-items/{supplierCode}', [App\Http\Controllers\RequestOrderContraller::class, 'getItemsBySupplier']);
Route::get('/api/get-item-stock/{itemCode}', [App\Http\Controllers\RequestOrderContraller::class, 'getItemStock']);


// GIN
Route::get('/allgins', [App\Http\Controllers\GinController::class, 'index'])->name('allgins');
Route::get('/creategin', [App\Http\Controllers\GinController::class, 'create'])->name('creategin');
Route::post('/insertgin', [App\Http\Controllers\GinController::class, 'store'])->name('insertgin');
Route::get('/showogins/{id}', [App\Http\Controllers\GinController::class, 'show'])->name('showogins');
Route::get('/editgins/{id}/edit', [App\Http\Controllers\GinController::class, 'edit'])->name('editgins');
Route::put('/updategins/{id}', [App\Http\Controllers\GinController::class, 'update'])->name('updategins');
Route::delete('/deletegins/{id}', [App\Http\Controllers\GinController::class, 'destroy'])->name('deletegins');

// routes/web.php
Route::get('/api/get-order-items/{orderRequestCode}', [GinController::class, 'getOrderItems']);

