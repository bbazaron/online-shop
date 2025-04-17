<?php

namespace Model;
class Product extends \Model\Model
{
    private int $id;
    private string $name;
    private string|null $description; // необязательное поле у продуктов
    private int $price;
    private string $image_url;
    private int $amount;

    protected function getTableName(): string
    {
        return 'products';
    }

    public function getAllProducts():array|null
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->getTableName()}");
        $products = $stmt->fetchAll();
        $arr=[];
        foreach ($products as $product){
            if (!$product){
                return null;
            }
            $obj = new self();
            $obj->id = $product['id'];
            $obj->name = $product['name'];
            $obj->price = $product['price'];
            $obj->image_url = $product['image_url'];

            if (isset ($product['description'])){ //описание может быть пустым
                $obj->description = $product['description'];
            } else {
                $obj->description = null;
            }
            array_push($arr, $obj); // объединение массивов $obj в конец $arr
        }
        return $arr;
    }

    public function getById($product_id): self|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTableName()}  WHERE id = :product_id");
        $stmt->execute([':product_id' => $product_id]);
        $product = $stmt->fetch();
        if (!$product){
            return null;
        }

        $obj = new self();
        $obj->id = $product['id'];
        $obj->name = $product['name'];
        $obj->price = $product['price'];
        $obj->image_url = $product['image_url'];
        if (isset ($product['description'])){ //описание может быть пустым
            $obj->description = $product['description'];
        } else {
            $obj->description = null;
        }

        return $obj;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string|null
    {
        if ($this->description === null){
            return null;
        } else {
            return $this->description;
        }
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getImageUrl(): string
    {
        return $this->image_url;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }



}