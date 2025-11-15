<?php

namespace App\Services\DTO;



use Illuminate\Http\Request;

class AddProductDTO
{
    public function __construct(
        private int $product_id,
    ){}

    public static function fromRequest(Request $request): self
    {
        return new self($request->get('product_id'));
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->product_id;
    }


}
