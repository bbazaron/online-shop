<?php

class User_products
{
    public function getCountByUserId($user_id): array|false
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM user_products WHERE user_id = :userId");
        $stmt->execute(['userId' => $user_id]);
        $data = $stmt->fetch();
        return $data;
    }

    public function getByUserId($user_id): array|false
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');

        $stmt = $pdo->prepare("SELECT * FROM user_products WHERE user_id = :userId ");
        $stmt->execute(['userId' => $user_id]);
        $data = $stmt->fetchAll(); // достаем все продукты у пользователя
        return $data;
    }
    public function getByProductIdUserId($product_id,$userid):array
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        $check = $pdo->prepare("SELECT * FROM user_products WHERE product_id = :product_id AND user_id = :userId");
        $check->execute(['product_id' => $product_id, 'userId' => $userid]);
        $data = $check->fetch();
        return $data;
    }

    public function insertToCart($userid, $product_id, $amount):string
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');

        $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $userid, 'product_id' => $product_id, 'amount' => $amount]);
        $message = "Продукты добавлены ";
        return $message;
    }

    public function updateToCart($userid, $product_id, $amount):string
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');

        $stmt = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['amount' => $amount, 'user_id' => $userid, 'product_id' => $product_id]);
        $message = "Продукты добавлены повторно";
        return $message;
    }
}