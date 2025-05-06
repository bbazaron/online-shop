<?php

namespace Model;

class OrderProducts extends \Model\Model

{
    private int $id;
    private int $productId;
    private int $amount;

    private string $product;
    private string|null $description; // необязательное поле у продуктов
    private int|float $price;
    private string $imageUrl;
    private int|float $totalSum;

    protected static function getTableName(): string
    {
        return 'order_products';
    }
    public static function create(int $orderId, int $productId, int $amount)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare(
            "INSERT INTO $tableName (order_id, product_id, amount)
                    VALUES (:orderId, :productId, :amount)");

        $stmt->execute(['orderId'=>$orderId, 'productId' => $productId, 'amount' => $amount]);

    }

    public static function getAllByOrderId(int $orderId): array|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM $tableName WHERE order_id = :orderId" );
        $stmt->execute(['orderId' => $orderId]);
        $orderProducts = $stmt->fetchAll();
        $arr=[];
        foreach ($orderProducts as $product){
            if (!$product){
                return null;
            }
            $obj = new self();
            $obj->id = $product['id'];
            $obj->productId = $product['product_id'];
            $obj->amount = $product['amount'];

            array_push($arr, $obj); // объединение массивов $obj в конец $arr
        }
        return $arr;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getTotalSum(): float|int
    {
        return $this->totalSum;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function getPrice(): float|int
    {
        return $this->price;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getProduct(): string
    {
        return $this->product;
    }




    public function setProduct(string $product): void
    {
        $this->product = $product;
    }

    public function setDescription(string|null $description): void
    {
        if ($description === null){
            $this->description = null;
        } else {
            $this->description = $description;
        }
    }

    public function setPrice(float|int $price): void
    {
        $this->price = $price;
    }

    public function setImageUrl(string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    public function setTotalSum(float|int $totalSum): void
    {
        $this->totalSum = $totalSum;
    }

}