<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YooKassaController;

Route::post('/yookassa/webhook', [YooKassaController::class, 'handle']);
