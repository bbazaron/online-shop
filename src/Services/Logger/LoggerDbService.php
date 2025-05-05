<?php

namespace Services\Logger;

use Services\Auth\AuthInterface;
use Services\Auth\AuthSessionService;
use Services\CartService;

class LoggerDbService implements LoggerInterface
{
    private AuthInterface $authService;
    private CartService $cartService;
    public function __construct()
    {
        $this->authService = new AuthSessionService();
        $this->cartService = new CartService();
    }
    public function error($exception){
        $user = $this->authService->getCurrentUser();
        $sum = $this->cartService->getSum();

        $pdo = new \PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');

        $logData = [
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'context' => ['user_id' => $user->getId(), 'order_sum' => $sum]
        ];

        $stmt = $pdo->prepare("
                                    INSERT INTO logs (message, file, line, created_at, context)
                                    VALUES (:message, :file, :line, :created_at, :context)
                                    ");

        $stmt->execute([
            ':message' => $logData['message'],
            ':file' => $logData['file'],
            ':line' => $logData['line'],
            ':created_at' => date('Y-m-d H:i:s'),
            ':context' => json_encode($logData['context']) //json для записи массива в бд
        ]);
        require_once'../Views/500.php';


    }
}