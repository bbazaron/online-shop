<?php

class App
{
    private array $routes = [
        '/registration' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getRegistrate'
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'registrate'
            ],
        ],

        '/login' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getLogin'
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'login'
            ],
        ],

        '/catalog' => [
            'GET' => [
                'class' => 'ProductController',
                'method' => 'catalog'
            ],
            'POST' => [
                'class' => 'ProductController',
                'method' => 'addToCart'
            ],
        ],

        '/profile' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getProfile'
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'getEditProfile'
            ],
        ],

        '/edit-Profile' => [
            'POST' => [
                'class' => 'UserController',
                'method' => 'editProfile'
            ],
        ],

        '/cart' => [
            'GET' => [
                'class' => 'CartController',
                'method' => 'getCart'
            ]
        ]
    ];
    public function run()
    {

        session_start();
        if (session_status() !== PHP_SESSION_ACTIVE) {
        }

        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        $routeMethode = $this->routes[$requestUri];
        $handler = $routeMethode[$requestMethod];
        $class = $handler['class'];
        $method = $handler['method'];
        require_once '../Controllers/' . $class . '.php';
        $controller = new $class();
        $controller->$method();

//        else {
//            http_response_code(404);
//            require_once './404.php';
//        }
    }
}