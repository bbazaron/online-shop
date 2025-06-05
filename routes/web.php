<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Models\Product;


Route::get('/signUp', [UserController::class, 'getSignUpForm'])->name('signUp');
Route::post('/signUp', [UserController::class, 'signUp'])->name('post.signUp');

Route::get('/login', [UserController::class, 'getLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('post.login');

Route::middleware('auth')->get('/profile',[UserController::class, 'getProfile'])->name('profile');

Route::middleware('auth')->get('/editProfile',[UserController::class, 'getEditProfile'])->name('editProfile');
Route::post('/editProfile',[UserController::class, 'handleEditProfile'])->name('post.editProfile');

Route::get('/logout',[UserController::class, 'logout'])->name('logout');

Route::get('/catalog',[ProductController::class, 'getCatalog'])->name('catalog');

Route::middleware('auth')->get('/cart',[CartController::class, 'getCart'])->name('cart');

Route::middleware('auth')->get('/orders',[ProductController::class, 'getOrders'])->name('orders');

Route::get('/product/{id}',[ProductController::class, 'getProductPage'])->name('productPage');

Route::middleware('auth')->get('/orderForm',[OrderController::class, 'getOrderForm'])->name('orderForm');
Route::post('/createOrder',[OrderController::class, 'createOrder'])->name('post.orderForm');

Route::post('/add-product',[CartController::class, 'addProductToCart'])->name('addProductToCart');
Route::post('/decrease-product',[CartController::class, 'decreaseProductFromCart'])->name('decreaseProductFromCart');

