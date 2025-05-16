<?php

namespace Request;

class AddNewProductRequest
{
    public function __construct(private array $post)
    {
    }

    public function getName():string
    {
        return $this->post['name'];
    }

    public function getDescription():string
    {
        return $this->post['description'];
    }

    public function getPrice():int
    {
        return $this->post['price'];
    }

    public function getImageUrl():string
    {
        return $this->post['image_url'];
    }

    public function validateProduct(): array
    {
        $errors = [];

        if (isset($this->post['name'])){
            $name = $this->post['name'];
            if (strlen($name) < 2) {
                $errors['name'] = 'Слишком короткое название';
            }
        } else {
            $errors['name']='Название должно быть заполнено';
        }

        if (isset($this->post['price'])){
            $price = $this->post['price'];
            if (is_numeric($price) === false || $price < 0) {
                $errors['price'] = "Введены неверные данные";
            } else {
                $errors['price']='Цена должна быть заполнена';
            }
        }

        if (isset($this->post['image_url'])){
            $image_url = $this->post['image_url'];
            if (strlen($image_url) < 2) {
                $errors['image_url'] = 'Слишком короткие данные';
            }
        } else {
            $errors['image_url']='Изображение должно быть заполнено';
        }

        return $errors;
    }
}