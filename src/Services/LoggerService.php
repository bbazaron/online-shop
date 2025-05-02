<?php

namespace Services;

use Services\Auth\AuthInterface;
use Services\Auth\AuthSessionService;

class LoggerService
{
    private AuthInterface $authService;
    private CartService $cartService;
    public function __construct()
    {
        $this->authService = new AuthSessionService();
        $this->cartService = new CartService();
    }
    public function errorToFile($exception){
        $dataFile = '../Storage/Log/errors.txt';
        $counterFile = '../Storage/Log/counter.txt'; // счетчик с цифрой

        $counter = file_exists($counterFile) ? (int)file_get_contents($counterFile) : 0; // счетчик из файла

        if (is_writable($dataFile)) {
            file_put_contents($dataFile, 'Record #'.($counter+1)."\n", FILE_APPEND );
            file_put_contents($dataFile, 'Message: '.$exception->getMessage()."\n", FILE_APPEND );
            file_put_contents($dataFile, 'File: '.$exception->getFile()."\n", FILE_APPEND );
            file_put_contents($dataFile, 'Line: '.$exception->getLine()."\n", FILE_APPEND );
            file_put_contents($dataFile, 'Date: '.date('Y-m-d H:i:s')."\n"."\n", FILE_APPEND );

            file_put_contents($counterFile, $counter + 1);
            require_once'../Views/500.php';
        } else {
            echo 'Файл недоступен для записи';
        }
    }

    public function errorsToDb($exception){
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

    }
}