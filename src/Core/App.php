<?php

namespace Core;
use Services\Logger\LoggerDbService;
use Services\Logger\LoggerInterface;
use Services\Logger\LoggerService;

class App
{
    private array $routes = [];
    private LoggerInterface $logger;
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

                 $requestClass = $handler['requestClass'];

                 try {
                     if ($requestClass !== null) {

                         $request = new $requestClass($_POST);
                         $controller->$method($request);

                     } else {
                         $controller->$method();
                     }
                 } catch (\Throwable $exception) {
                     $this->logger = new LoggerDbService();
                     $this->logger->error($exception); // запись в бд
                 }


             } else {
                 echo "$requestMethod не поддерживается для $requestUri";
             }

        } else {
            http_response_code(404);
            require_once '../Views/404.php';
        }


    }

//    private function getRequest($controller, $method)
//    {
//        if ($controller instanceof BaseController) {
//
//        }
//    }


    public function get(string $route, string $className, string $method, string $requestClass = null)
    {
        $this->routes[$route]['GET'] = [
            'class' => $className,
            'method' => $method,
            'requestClass' => $requestClass
        ];
    }

    public function post(string $route, string $className, string $method, string $requestClass = null)
    {
        $this->routes[$route]['POST'] = [
            'class' => $className,
            'method' => $method,
            'requestClass' => $requestClass
        ];
    }

    public function put(string $route, string $className, string $method)
    {
        $this->routes[$route]['PUT'] = [
            'class' => $className,
            'method' => $method
        ];
    }

    public function delete(string $route, string $className, string $method)
    {
        $this->routes[$route]['DELETE'] = [
            'class' => $className,
            'method' => $method
        ];
    }
}