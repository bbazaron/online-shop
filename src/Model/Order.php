<?php

namespace Model;

class Order extends \Model\Model
{
    public function create( string $contactName, string $contactNumber, string $address, string $comment,int $userId):int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO orders ( contact_name, contact_phone, address, comment, user_id)
                    VALUES (:contactName, :contactNumber, :address, :comment, :userId)  RETURNING id"
        );

        $stmt->execute([
                        'contactName' => $contactName,
                        'contactNumber' => $contactNumber,
                        'address' => $address,
                        'comment' => $comment,
                        'userId'=>$userId
                    ]);

        $data = $stmt->fetch();
        return $data['id'];
    }


    public function getOrderById(int $id):array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE user_id = :userId");
        $stmt->execute(['userId'=>$id]);
        return $stmt->fetch();
    }

    public function getAllByUserId($id):array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE user_id = :userId");
        $stmt->execute(['userId'=>$id]);
        $data = $stmt->fetchAll();
        return $data;
    }
}