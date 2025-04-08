<?php

use Controllers\CartController;
use Controllers\OrderController;
use Controllers\ProductController;
use Controllers\UserController;

$autoload = function (string $classname) {

    $path = str_replace("\\", "/", $classname);
    $path = './../'. $path. '.php';
    if (file_exists($path)) {
        require_once $path;
        return true;
    }

    return false;
};

spl_autoload_register($autoload);

$app = new \Core\App();

$app->addRoute('/registration', 'GET', UserController::class, 'getRegistrate');
$app->addRoute('/registration', 'POST', UserController::class, 'registrate');

$app->addRoute('/login', 'GET', UserController::class, 'getlogin');
$app->addRoute('/login', 'POST', UserController::class, 'login');

$app->addRoute('/catalog', 'GET', ProductController::class, 'catalog');
$app->addRoute('/catalog', 'POST', ProductController::class, 'addToCart');


$app->addRoute('/profile', 'GET', UserController::class, 'getProfile');
$app->addRoute('/profile', 'POST', UserController::class, 'getEditProfile');

$app->addRoute('/editProfile', 'POST', UserController::class, 'editProfile');

$app->addRoute('/cart', 'GET', CartController::class, 'getCart');

$app->addRoute('/logout', 'POST', UserController::class, 'logout');

$app->addRoute('/create-order', 'GET', OrderController::class, 'getCheckoutForm');
$app->addRoute('/create-order', 'POST', OrderController::class, 'handleCheckout');

$app->addRoute('/orders', 'GET', OrderController::class, 'getOrders');

$app->run();
