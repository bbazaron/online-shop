<?php

namespace Controllers;
use \Services\AuthService;
abstract class  BaseController
{
    protected AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

}