<?php

namespace Model;

class Order extends \Model\Model
{
    public function insert($userId, string $name, $phoneNumber, string $address)
    {
        $stmt = $this->pdo->prepare("INSERT INTO orders (user_id, name, phone_number, address) VALUES (:userId, :name, :phoneNumber, :address)");
        $stmt->execute(['userId'=>$userId, 'name' => $name, 'phoneNumber' => $phoneNumber, 'address' => $address]);
    }

    public function getIdByUserId($userId):array // id заказа нужен для внесения данных в таблицу order_products
    {
        $stmt = $this->pdo->prepare("SELECT id FROM orders WHERE user_id = :userId");
        $stmt->execute(['userId'=>$userId]);
        return $stmt->fetch();
    }
}