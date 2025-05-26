<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Models\Product;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/signUp', [UserController::class, 'getSignUpForm']);
Route::post('/signUp', [UserController::class, 'signUp']);
Route::get('/login', [UserController::class, 'getLoginForm']);
Route::post('/login', [UserController::class, 'login']);
//Route::get('/catalog', [ProductController::class, 'getCatalog'])->middleware('auth');
Route::get('/catalog', function () {
    return view('catalog', [
        'products' => Product::all()
    ]);
});
