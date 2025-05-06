<?php

namespace Model;
use PDO;
abstract class Model
{
    protected static PDO $pdo;
    public static function getPDO():PDO
    {
       static::$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
       return static::$pdo;
    }
    abstract static protected function getTableName(): string;


}