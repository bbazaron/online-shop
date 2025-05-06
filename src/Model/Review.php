<?php

namespace Model;

class Review extends \Model\Model
{
    private string $name;
    private int $rating;
    private string $comment;
    protected static function getTableName(): string
    {
        return 'reviews';
    }

    public static function create(int $product_id,int $user_id, string $name, int $rating, string $comment):bool
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare(
            "INSERT INTO $tableName (product_id, user_id, name, rating, comment)
                    VALUES (:product_id,:user_id, :name, :rating, :comment)");

        $stmt->execute(['product_id'=>$product_id,'user_id'=>$user_id, 'name' => $name, 'rating' => $rating, 'comment' => $comment]);
        return true;
    }

    public static function getByProductId(int $product_id):?array
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM $tableName WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $product_id]);
        $reviews = $stmt->fetchAll();

        $arr=[];
        foreach ($reviews as $review) {
            if (!$review) {
                return null;
            }
            $obj = new self();
            $obj->name = $review['name'];
            $obj->rating = $review['rating'];
            $obj->comment = $review['comment'];
            $arr[] = $obj;
        }
        return $arr;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function getComment(): string
    {
        return $this->comment;
    }


}