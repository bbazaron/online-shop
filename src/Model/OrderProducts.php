<?php

namespace Model;

class OrderProducts extends \Model\Model
{
    public function create(int $orderId, int $productId, int $amount)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO order_products (order_id, product_id, amount)
                    VALUES (:orderId, :productId, :amount)");

        $stmt->execute(['orderId'=>$orderId, 'productId' => $productId, 'amount' => $amount]);

    }

    public function getAllByOrderId(int $orderId): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM order_products WHERE order_id = :orderId" );
        $stmt->execute(['orderId' => $orderId]);
        $data = $stmt->fetchAll();
        return $data;
    }

}