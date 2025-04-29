<?php

namespace Services\Auth;

use Model\User;

interface AuthInterface
{
    public function check():bool;

    public function getCurrentUser():?User;

    public function auth(\DTO\AuthDTO $dto):bool;


    public function logout();

}