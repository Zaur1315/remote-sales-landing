<?php

use App\Http\Controllers\RemoteSalesApplicationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RemoteSalesApplicationController::class, 'index'])
    ->name('remote-sales.index');

Route::post('/apply', [RemoteSalesApplicationController::class, 'store'])
    ->name('remote-sales.store');
