<?php

namespace DTO;

class AddProductDTO
{
    public function __construct(
        private int $productId,
        private \Model\User $user,
        private int $amount
    ){
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getUser(): \Model\User
    {
        return $this->user;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }


}