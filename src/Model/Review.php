<?php

namespace Model;

class Review extends \Model\Model
{
    private string $name;
    private int $rating;
    private string $comment;
    protected function getTableName(): string
    {
        return 'reviews';
    }

    public function create(int $product_id,int $user_id, string $name, int $rating, string $comment):bool
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO {$this->getTableName()} (product_id, user_id, name, rating, comment)
                    VALUES (:product_id,:user_id, :name, :rating, :comment)");

        $stmt->execute(['product_id'=>$product_id,'user_id'=>$user_id, 'name' => $name, 'rating' => $rating, 'comment' => $comment]);
        return true;
    }

    public function getByProductId(int $product_id):?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE product_id = :product_id");
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