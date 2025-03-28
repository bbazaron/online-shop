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

        '/edit-profile' => [
            'POST' => [
                'class' => 'UserController',
                'method' => 'editProfile'
            ],
        ],

        '/cart' => [
            'GET' => [
                'class' => 'CartController',
                'method' => 'getCart'
            ],
        ],

        '/logout' => [
            'POST' => [
                'class' => 'UserController',
                'method' => 'logout'
            ]
        ]
    ];
    public function run()
    {

        session_start();
        if (session_status() !== PHP_SESSION_ACTIVE) {
        }

        $requestUri = $_SERVER['REQUEST_URI']; //registration
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$requestUri])) { //registration
            $routeMethode = $this->routes[$requestUri];


             if (isset($routeMethode[$requestMethod])) {
                 $handler = $routeMethode[$requestMethod];
                 $class = $handler['class'];
                 $method = $handler['method'];

                 require_once "../Controllers/$class.php";

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