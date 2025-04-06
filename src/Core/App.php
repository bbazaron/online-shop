<?php

namespace Core;
use Controllers\ProductController;
use Controllers\UserController;
use Controllers\CartController;
use Controllers\OrderController;

class App
{
    private array $routes = [
        '/registration' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'getRegistrate'
            ],
            'POST' => [
                'class' => UserController::class,
                'method' => 'registrate'
            ],
        ],

        '/login' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'getLogin'
            ],
            'POST' => [
                'class' => UserController::class,
                'method' => 'login'
            ],
        ],

        '/catalog' => [
            'GET' => [
                'class' => ProductController::class,
                'method' => 'catalog'
            ],
            'POST' => [
                'class' => ProductController::class,
                'method' => 'addToCart'
            ],
        ],

        '/profile' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'getProfile'
            ],
            'POST' => [
                'class' => UserController::class,
                'method' => 'getEditProfile'
            ],
        ],

        '/edit-profile' => [
            'POST' => [
                'class' => UserController::class,
                'method' => 'editProfile'
            ],
        ],

        '/cart' => [
            'GET' => [
                'class' => CartController::class,
                'method' => 'getCart'
            ],
        ],

        '/logout' => [
            'POST' => [
                'class' => UserController::class,
                'method' => 'logout'
            ],
        ],

        '/create-order' => [
            'GET' => [
                'class' => OrderController::class,
                'method' => 'getCheckOutForm'
                    ],
            'POST' => [
                'class' => OrderController::class,
                'method' => 'handleCheckOut'
            ]
            ],

        '/orders' => [
            'GET' => [
                'class' => OrderController::class,
                'method' => 'getOrders'
            ]
        ]
    ];
    public function run()
    {

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $requestUri = $_SERVER['REQUEST_URI']; //registration
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$requestUri])) { //registration
            $routeMethode = $this->routes[$requestUri];


             if (isset($routeMethode[$requestMethod])) {
                 $handler = $routeMethode[$requestMethod];
                 $class = $handler['class'];
                 $method = $handler['method'];

                 $controller = new $class();
                 $controller->$method();

             } else {
                 echo "$requestMethod не поддерживается для $requestUri";
             }

        } else {
            http_response_code(404);
            require_once '../Views/404.php';
        }


    }
}