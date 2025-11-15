<?php

namespace App\Services\DTO;

use App\Http\Requests\EditProductRequest;
use Faker\Guesser\Name;

class EditProductDTO
{
    public function __construct(
        private string|null $name,
        private string|null $description,
        private int|null $price,
        private string|null $image,
    ){}

    public static function fromRequest(EditProductRequest $request): self
    {
        return new self(
            $request->get('name'),
            $request->get('description'),
            $request->get('price'),
            $request->get('image')
        );
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return int|null
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }


}
