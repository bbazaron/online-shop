<?php

namespace DTO;

class AddProductDTO
{
    public function __construct(
        private int $productId,
        private int $amount
    ){
    }

    public function getProductId(): int
    {
        return $this->productId;
    }


    public function getAmount(): int
    {
        return $this->amount;
    }


}