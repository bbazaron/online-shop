<?php

namespace Model;
class UserProducts extends \Model\Model
{
    public function getCountByUserId($user_id): array|false
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM user_products WHERE user_id = :userId");
        $stmt->execute(['userId' => $user_id]);
        $data = $stmt->fetch();
        return $data;
    }

    public function getByUserId($user_id): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user_products WHERE user_id = :userId ");
        $stmt->execute(['userId' => $user_id]);
        $data = $stmt->fetchAll(); // достаем все продукты у пользователя
        return $data;
    }
    public function getByProductIdUserId($product_id,$userid):array|false
    {
        $check = $this->pdo->prepare("SELECT * FROM user_products WHERE product_id = :product_id AND user_id = :userId");
        $check->execute(['product_id' => $product_id, 'userId' => $userid]);
        $data = $check->fetch();
        return $data;
    }

    public function insertToCart($userid, $product_id, $amount):string
    {
        $stmt = $this->pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $userid, 'product_id' => $product_id, 'amount' => $amount]);
        $message = "Продукты добавлены ";
        return $message;
    }

    public function updateToCart($userid, $product_id, $amount):string
    {
        $stmt = $this->pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['amount' => $amount, 'user_id' => $userid, 'product_id' => $product_id]);
        $message = "Продукты добавлены повторно";
        return $message;
    }

    public function deleteFromCart($userId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);

    }
}