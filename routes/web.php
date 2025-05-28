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
Route::get('/profile',[UserController::class, 'getProfile']);
Route::get('/editProfile',[UserController::class, 'getEditProfile']);
Route::post('/editProfile',[UserController::class, 'handleEditProfile']);
Route::get('/logout',[UserController::class, 'logout']);

Route::get('/catalog',[ProductController::class, 'getCatalog']);
Route::post('/product',[ProductController::class, 'getProductPage']);
Route::post('/add-product',[ProductController::class, 'addProductToCart']);
Route::post('/decrease-product',[ProductController::class, 'decreaseProductFromCart']);

