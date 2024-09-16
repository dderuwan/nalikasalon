<?php
Route::get('/subpackages', [App\Http\Controllers\subPackagesContraller::class, 'index'])->name('subpackages');