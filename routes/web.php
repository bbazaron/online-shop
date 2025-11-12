<?php

use App\Http\Controllers\SearchController;
use App\Http\Controllers\YooKassaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Models\Product;
use App\Http\Controllers\TestEmailController;

    Route::get('/signUp', [UserController::class, 'getSignUpForm'])->name('signUp');
    Route::post('/signUp', [UserController::class, 'signUp'])->name('post.signUp');
    Route::get('/login', [UserController::class, 'getLoginForm'])->name('login');
    Route::post('/login', [UserController::class, 'login'])->name('post.login');
    Route::get('/catalog', [ProductController::class, 'getCatalog'])->name('catalog');
    Route::get('/product/{id}', [ProductController::class, 'getProductPage'])->name('productPage');

    Route::get('/email/test',[TestEmailController::class, 'send']);
    Route::get('/email/receive',[TestEmailController::class, 'receive']);

    Route::get('/send-test-email', [\App\Http\Controllers\MailTestController::class, 'send']);

Route::middleware('auth')->group(function()
{
    Route::get('/orderForm',[OrderController::class, 'getOrderForm'])->name('orderForm');
    Route::get('/orders',[OrderController::class, 'getOrders'])->name('orders');
    Route::get('/cart',[CartController::class, 'getCart'])->name('cart');
    Route::get('/editProfile',[UserController::class, 'getEditProfile'])->name('editProfile');
    Route::get('/profile',[UserController::class, 'getProfile'])->name('profile');
    Route::post('/createOrder',[OrderController::class, 'createOrder'])->name('post.orderForm');
    Route::post('/review',[ProductController::class, 'createReview'])->name('review');
    Route::get('/logout',[UserController::class, 'logout'])->name('logout');
    Route::post('/editProfile',[UserController::class, 'handleEditProfile'])->name('post.editProfile');
    Route::post('/add-product',[CartController::class, 'addProductToCart'])->name('addProductToCart');
    Route::post('/decrease-product',[CartController::class, 'decreaseProductFromCart'])->name('decreaseProductFromCart');

    Route::get('/editProducts',[ProductController::class, 'getEditProducts'])->name('editProducts');
    Route::get('/products/{product}',[ProductController::class, 'getEditProductForm'])->name('editProductForm');
    Route::post('/products/{product}',[ProductController::class, 'handleEditProductForm'])->name('post.editProductForm');

    Route::get('/createProductForm',[ProductController::class, 'getCreateProductForm'])->name('createProductForm');
    Route::post('/create-product',[ProductController::class, 'create'])->name('post.createProductForm');
    Route::delete('/products/{product}',[ProductController::class, 'delete'])->name('deleteProduct');

    Route::get('/deleteTask/{taskId}',[OrderController::class, 'deleteTask'])->name('deleteTask'); // тестовый

    Route::get('/search',[SearchController::class, 'search'])->name('catalog.search');


});
