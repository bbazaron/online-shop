<?php

namespace Request;

class ReviewRequest
{
    public function __construct(private array $post)
    {
    }

    public function getName(): string
    {
        return $this->post['name'];
    }

    public function getRating(): int
    {
        return $this->post['rating'];
    }

    public function getComment(): string
    {
        return $this->post['comment'];
    }

    public function getProductId(): string
    {
        return $this->post['product_id'];
    }


    public function validateReview(): array
    {
        $errors = [];

        if (isset($this->post['name'])){
            $name = $this->post['name'];
            if (strlen($name) < 2) {
                $errors['name'] = 'Слишком короткое имя';
            }
        } else {
            $errors['name']='Имя должно быть заполнено';
        }

        if (isset($this->post['rating'])){
            $rating = $this->post['rating'];
            if (is_numeric($rating) === false) {
                $errors['rating']='Введите число';
            } elseif ($rating === '0') {
                $errors['rating']='Не может быть число 0';
            }

        } else {
            $errors['rating']='Поле должно быть заполнено';
        }

        if (isset($this->post['comment'])){
            $comment = $this->post['comment'];
            if (strlen($comment) < 2) {
                $errors['comment']='Недопустимая длина отзыва';
            }
        }

        return $errors;
    }


}