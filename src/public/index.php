<?php

use Controllers\CartController;
use Controllers\OrderController;
use Controllers\ProductController;
use Controllers\UserController;
use Core\Autoloader;

require_once "./../Core/Autoloader.php";

$path = dirname(__DIR__);
\Core\Autoloader::register($path);

$app = new \Core\App();

$app->get('/registration', UserController::class, 'getRegistrate');
$app->post('/registration', UserController::class, 'registrate', \Request\RegistrateRequest::class);

$app->get('/login', UserController::class, 'getlogin');
$app->post('/login', UserController::class, 'login', \Request\LoginRequest::class);

$app->get('/catalog', ProductController::class, 'getCatalog');
$app->post('/add-product', CartController::class, 'addProductToCart', \Request\AddProductRequest::class);
$app->post('/decrease-product', CartController::class, 'decreaseProductFromCart',\Request\AddProductRequest::class);
$app->post('/product', ProductController::class, 'getProductPage');
$app->post('/review', ProductController::class, 'createReview', \Request\ReviewRequest::class);


$app->get('/profile', UserController::class, 'getProfile');
$app->post('/profile', UserController::class, 'getEditProfile');

$app->post('/editProfile', UserController::class, 'editProfile', \Request\EditProfileRequest::class);

$app->get('/cart', CartController::class, 'getCart');

$app->post('/logout',  UserController::class, 'logout');

$app->get('/create-order',  OrderController::class, 'getCheckoutForm');
$app->post('/create-order', OrderController::class, 'handleCheckout', \Request\OrderRequest::class);

$app->get('/orders',  OrderController::class, 'getOrders');

$app->run();
