<?php

namespace Services\Logger;

use Services\Auth\AuthInterface;
use Services\Auth\AuthSessionService;
use Services\CartService;
use \Model\Logs;

class LoggerDbService implements LoggerInterface
{
    private AuthInterface $authService;
    private CartService $cartService;
    public function __construct()
    {
        $this->authService = new AuthSessionService();
        $this->cartService = new CartService();
    }
    public function error(\Throwable $exception){
        $user = $this->authService->getCurrentUser();
        $sum = $this->cartService->getSum();

        Logs::insert($exception, $user->getId(), $sum);

        require_once'../Views/500.php';
        exit;


    }
}