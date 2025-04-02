<?php

namespace Model;

class OrderProducts extends \Model\Model
{
    public function insert($orderId, $userId, $productId, $amount)
    {
        $stmt = $this->pdo->prepare("INSERT INTO order_products (order_id, user_id, product_id, amount) VALUES (:orderId, :userId, :productId, :amount)");
        $stmt->execute(['orderId'=>$orderId, 'userId' => $userId, 'productId' => $productId, 'amount' => $amount]);
    }

}