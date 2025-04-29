<?php

namespace Controllers;
use Services\Auth\AuthInterface;
use Services\Auth\AuthSessionService;

abstract class  BaseController
{
    protected AuthInterface $authService;

    public function __construct()
    {
        $this->authService = new AuthSessionService();
    }

}