<?php

namespace Model;
class UserProducts extends \Model\Model
{
    private int $id;
    private int $userId;
    private int $productId;
    private int $amount;
    private int $count;

    protected function getTableName(): string
    {
        return 'user_products';
    }

    public function getCountByUserId(int $user_id): self|null
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM {$this->getTableName()} WHERE user_id = :userId");
        $stmt->execute(['userId' => $user_id]);
        $count = $stmt->fetch();

        if (!$count){
            return null;
        }
        $obj = new self();
        $obj->count = $count['count'];
        return $obj;
    }

    public function getAllByUserId(int $user_id): array|null // достаем все продукты у пользователя
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE user_id = :userId ");
        $stmt->execute(['userId' => $user_id]);
        $products = $stmt->fetchAll();
        $arr =[];

        foreach ($products as $product) {
            if (!$product) {
                return null;
            }

            $obj = new self();
            $obj->id = $product['id'];
            $obj->userId = $product['user_id'];
            $obj->productId = $product['product_id'];
            $obj->amount = $product['amount'];
            $arr[] = $obj;
        }
        return $arr;
    }
    public function getByProductIdUserId($product_id,$userId):array|false
    {
        $check = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE product_id = :product_id AND user_id = :userId");
        $check->execute(['product_id' => $product_id, 'userId' => $userId]);
        $data = $check->fetch();
        return $data;
    }

    public function insertToCart($userid, $product_id,$amount)
    {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->getTableName()} (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $userid, 'product_id' => $product_id,'amount' => $amount]);
    }

    public function updateToCart($userid, $product_id, $amount)
    {
        $stmt = $this->pdo->prepare("UPDATE {$this->getTableName()} SET amount = :amount WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['amount' => $amount, 'user_id' => $userid, 'product_id' => $product_id]);
    }

    public function deleteByUserId($userId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->getTableName()} WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
    }
    public function deleteByUserIdProductId($user_id, $product_id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->getTableName()} WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id'=>$user_id, 'product_id' => $product_id]);
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCount(): int
    {
        return $this->count;
    }





}