<?php

use App\Http\Controllers\Orders\OrderController;
use Illuminate\Support\Facades\Route;

Route::apiResource('orders', OrderController::class);
