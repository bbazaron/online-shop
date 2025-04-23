<?php

namespace DTO;

class DecreaseProductDTO
{
    public function __construct(
        private int $productId,
        private \Model\User $user,
    ){
    }

    public function getUser(): \Model\User
    {
        return $this->user;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }


}