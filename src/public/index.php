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
$app->post('/registration', UserController::class, 'registrate');

$app->get('/login', UserController::class, 'getlogin');
$app->post('/login', UserController::class, 'login');

$app->get('/catalog', ProductController::class, 'getCatalog');
$app->post('/add-product', CartController::class, 'addProductToCart');
$app->post('/decrease-product', CartController::class, 'decreaseProductFromCart');
$app->post('/product', ProductController::class, 'getProductPage');
$app->post('/review', ProductController::class, 'createReview');


$app->get('/profile', UserController::class, 'getProfile');
$app->post('/profile', UserController::class, 'getEditProfile');

$app->post('/editProfile', UserController::class, 'editProfile');

$app->get('/cart', CartController::class, 'getCart');

$app->post('/logout',  UserController::class, 'logout');

$app->get('/create-order',  OrderController::class, 'getCheckoutForm');
$app->post('/create-order', OrderController::class, 'handleCheckout');

$app->get('/orders',  OrderController::class, 'getOrders');

$app->run();
