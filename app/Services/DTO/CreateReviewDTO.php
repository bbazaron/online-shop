<?php

namespace App\Services\DTO;


use App\Http\Requests\CreateReviewRequest;

class CreateReviewDTO
{
    public function __construct(
        private string $name,
        private string|null $comment,
        private int $rating,
        private int $product_id,
    ){}

    public static function fromRequest(CreateReviewRequest $request): self
    {
        return new self(
            $request->get('name'),
            $request->get('comment'),
            $request->get('rating'),
            $request->get('product_id')
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
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @return int
     */
    public function getRating(): int
    {
        return $this->rating;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->product_id;
    }


}
