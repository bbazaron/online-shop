<?php

namespace Core;
use Controllers\ProductController;
use Controllers\UserController;
use Controllers\CartController;
use Controllers\OrderController;

class App
{
    private array $routes = [];
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

    public function addRoute(string $route, string $routeMethod, string $className, string $method)
    {
        $this->routes[$route][$routeMethod] = [
                'class' => $className,
                'method' => $method
        ];
    }
}