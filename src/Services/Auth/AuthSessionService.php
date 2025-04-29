<?php

namespace Services\Auth;
use Model\User;

class AuthSessionService implements AuthInterface
{
    private User $userModel;
    public function __construct()
    {
        $this->userModel = new User();
    }
    public function check():bool
    {
        $this->startSession();
        return isset($_SESSION['userId']);
    }

    public function getCurrentUser():?User
    {
        $this->startSession();

        if ($this->check()){
            $userId = $_SESSION['userId'];
            return $this->userModel->getById($userId);

        } else {
            return null;
        }
    }
    public function auth(\DTO\AuthDTO $dto):bool
    {
        $user = $this->userModel->getByEmail($dto->getEmail());

        if (!$user) {
            return false;
        } else {
            $passwordDb = $user->getPassword();
            if (password_verify($dto->getPassword(), $passwordDb)) {
                $this->startSession();
                $_SESSION['userId'] = $user->getId();
                return true;
            } else {
                return false;
            }
        }
    }

    public function logout()
    {
        if ($this->check()===false) {
            header("Location: /login");
            exit;
        }
        unset($_SESSION['userId']);
        session_destroy();
    }

    protected function startSession()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }
}