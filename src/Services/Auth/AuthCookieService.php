<?php

namespace Services\Auth;

use Model\User;

class AuthCookieService implements AuthInterface
{
    private User $userModel;
    public function __construct()
    {
        $this->userModel = new User();
    }
    public function check():bool
    {
        return isset($_COOKIE['userId']);
    }

    public function getCurrentUser():?User
    {

        if ($this->check()){
            $userId = $_COOKIE['userId'];
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
                setcookie('userId', $user->getId());
                return true;
            } else {
                return false;
            }
        }
    }

    public function logout()
    {
        setcookie('userId', '', time() - 3600,'/');
        unset($_COOKIE['userId']);
    }

}