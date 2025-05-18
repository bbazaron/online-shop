<?php

namespace Request;

class EditProductRequest
{
    public function __construct(private array $post)
    {
    }

    public function getId(): int
    {
        return $this->post['product_id'];
    }
    public function getName():string
    {
        return $this->post['name'];
    }

    public function getDescription():string
    {
        return $this->post['description'];
    }

    public function getPrice():int|string
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
//        echo"<pre>";print_r($this->post);exit;

        if ($this->post['name'] !== '' && strlen($this->post['name'])<2)
        {
            $errors['name'] = 'Слишком короткое название';
        }

        if ($this->post['description'] !== '' && strlen($this->post['description'])<2)
        {
            $errors['description'] = 'Слишком короткое описание';
        }

        if ($this->post['price'] !== '' && ($this->post['price']<0 || $this->post['price']===0))
        {
            $errors['price'] = 'Неверные данные';
        }

        if ($this->post['image_url'] !== '' && strlen($this->post['image_url'])<2)
        {
            $errors['image_url'] = 'Слишком короткие данные';
        }

        return $errors;
    }
}