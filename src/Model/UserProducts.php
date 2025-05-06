<?php

namespace Model;
class UserProducts extends \Model\Model
{
    private int $id;
    private int $userId;
    private int $productId;
    private int $amount;
    private int $count;
    private int $price;
    private Product $product;

    protected static function getTableName(): string
    {
        return 'user_products';
    }

    public static function getCountByUserId(int $user_id): self|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT COUNT(*) FROM $tableName WHERE user_id = :userId");
        $stmt->execute(['userId' => $user_id]);
        $count = $stmt->fetch();

        if (!$count){
            return null;
        }
        $obj = new self();
        $obj->count = $count['count'];
        return $obj;
    }

    public static function getAllByUserId(int $user_id): array|null // достаем все продукты у пользователя
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM $tableName WHERE user_id = :userId ");
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

    public static function getAllByUserIdWithProducts(int $user_id): array|null // достаем все продукты у пользователя
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM $tableName up INNER JOIN products p ON up.product_id = p.id WHERE user_id = :userId ");
        $stmt->execute(['userId' => $user_id]);
        $userProducts = $stmt->fetchAll();

        if (!$userProducts) {
            return null;
        }

        foreach ($userProducts as $userProduct) {
            if (!$userProduct) {
                return null;
            }

            $obj = new self();
            $obj->id = $userProduct['id'];
            $obj->userId = $userProduct['user_id'];
            $obj->productId = $userProduct['product_id'];
            $obj->amount = $userProduct['amount'];
            $obj->price = $userProduct['price'];

            $productData=[
                'id' => $userProduct['product_id'],
                'name' => $userProduct['name'],
                'description' => $userProduct['description'],
                'image_url' => $userProduct['image_url'],
                'amount' => $userProduct['amount'],
                'price' => $userProduct['price']

            ];

            $product = Product::createObj($productData);
            $obj->setProduct($product);
            $arr[] = $obj;
        }
        return $arr;
    }
    public static function getByProductIdUserId($product_id,$userId):array|false
    {
        $tableName = static::getTableName();
        $check = static::getPDO()->prepare("SELECT * FROM $tableName WHERE product_id = :product_id AND user_id = :userId");
        $check->execute(['product_id' => $product_id, 'userId' => $userId]);
        $data = $check->fetch();
        return $data;
    }

    public static function insertToCart($userid, $product_id,$amount)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("INSERT INTO $tableName (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $userid, 'product_id' => $product_id,'amount' => $amount]);
    }

    public static function updateToCart($userid, $product_id, $amount)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("UPDATE $tableName SET amount = :amount WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['amount' => $amount, 'user_id' => $userid, 'product_id' => $product_id]);
    }

    public static function deleteByUserId($userId)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("DELETE FROM $tableName WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
    }
    public static function deleteByUserIdProductId($user_id, $product_id)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("DELETE FROM $tableName WHERE user_id = :user_id AND product_id = :product_id");
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

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }









}