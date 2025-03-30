<?php

class MyPdo
{
    private PDO $PDO;
    public function __construct()
    {
       $this->PDO = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
    }

    public function getPDO()
    {
        return $this->PDO;
    }
}