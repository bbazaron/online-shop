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

    protected static function getTableName(): string
    {
        return 'products';
    }

    public static function getAll():array|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->query("SELECT * FROM $tableName");
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

    public static function getById($product_id): self|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM $tableName  WHERE id = :product_id");
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

    public static function insert(string $name, int $price, string $image_url,string $description=null)
    {
        $tableName = static::getTableName();
        if ($description!==null) {
            $stmt = static::getPDO()->prepare("INSERT INTO $tableName (name, description, price, image_url)
                                                    VALUES (:name, :description, :price, :image_url)");
            $stmt->execute(['name' => $name,
                'description' => $description,
                'price' => $price,
                'image_url' => $image_url]);
        } else {
            $stmt = static::getPDO()->prepare("INSERT INTO $tableName (name, price, image_url)
                                                    VALUES (:name, :price, :image_url)");
            $stmt->execute(['name' => $name,
                'price' => $price,
                'image_url' => $image_url]);
        }
    }

    public static function deleteById(int $id)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("DELETE FROM $tableName WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    public static function updateNameById(int $id, string $name)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("UPDATE $tableName SET name = :name WHERE id = :id");
        $stmt->execute(['name' => $name, 'id' => $id]);
    }
    public static function updateDescriptionById(int $id, string $description)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("UPDATE $tableName SET description = :description WHERE id = :id");
        $stmt->execute(['description' => $description, 'id' => $id]);
    }
    public static function updatePriceById(int $id, int $price)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("UPDATE $tableName SET price = :price WHERE id = :id");
        $stmt->execute(['price' => $price, 'id' => $id]);
    }
    public static function updateImageUrlById(int $id, string $image_url)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("UPDATE $tableName SET image_url = :image_url WHERE id = :id");
        $stmt->execute(['image_url' => $image_url, 'id' => $id]);
    }

    public static function createObj(array $product, int $id=null): self|null
    {
        if (!$product){
            return null;
        }
        $obj = new self();

        if ($id !== null){
            $obj->setId($id);
        } else {
            $obj->setId($product['id']);
        }

        $obj->setName($product['name']);
        $obj->setDescription($product['description']);
        $obj->setPrice($product['price']);
        $obj->setAmount($product['amount']);

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

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function setImageUrl(string $image_url): void
    {
        $this->image_url = $image_url;
    }




}