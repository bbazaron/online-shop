<?php

namespace App\Services\DTO;

use App\Http\Requests\CreateProductRequest;

class CreateProductDTO
{
    public function __construct(
        private string $name,
        private int $price,
        private string|null $description,
        private string|null $image,
    ){}

    public static function fromRequest(CreateProductRequest $request): self
    {
        return new self(
            $request->get('name'),
            $request->get('price'),
            $request->get('description'),
            $request->get('image')
        );
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }


}
