<?php

namespace DTO;

class AddNewProductDTO
{
    public function __construct(
        private string $name,
        private int $price,
        private string $image_url,
        private string $description
    ){
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getImageUrl(): string
    {
        return $this->image_url;
    }

    public function getDescription(): string
    {
        return $this->description;
    }


}