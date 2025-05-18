<?php

namespace DTO;

class EditProductDTO
{
    public function __construct(
        private int $id,
        private string $name,
        private int $price,
        private string $image_url,
        private string $description
    ){
    }

    public function getId(): string
    {
        return $this->id;
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