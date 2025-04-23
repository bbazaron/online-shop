<?php

namespace Services;

use DTO\AddProductDTO;

class CartService
{
    private \Model\UserProducts $userProducts;

    public function __construct()
    {
        $this->userProducts = new \Model\UserProducts();
    }

    public function addProduct(\DTO\AddProductDTO $dto):string
    {

        $data = $this->userProducts->getByProductIdUserId($dto->getProductId(), $dto->getUser()->getId());

        if ($data === false) {
            $this->userProducts->insertToCart($dto->getUser()->getId(), $dto->getProductId(), $dto->getAmount());
            return true;
        } else {
            $amount = $dto->getAmount() + 1;
            $this->userProducts->updateToCart($dto->getUser()->getId(), $dto->getProductId(), $amount);
            return false;
        }
    }

    public function decreaseProduct(\DTO\DecreaseProductDTO $dto):string
    {
        $data = $this->userProducts->getByProductIdUserId($dto->getProductId(), $dto->getUser()->getId());

        if ($data === false) {
            $message = "Продукта нет в корзине";
            return $message;

        } elseif($data['amount'] === 1) {
            $this->userProducts->deleteByUserIdProductId($dto->getUser()->getId(), $dto->getProductId());
            $message = "Продукт удален из корзины";
            return $message;
        }

        else {
            $amount = $data['amount'] - 1;
            $this->userProducts->updateToCart($dto->getUser()->getId(), $dto->getProductId(),$amount);
            $message = "Количество продукта уменьшено";
            return $message;
        }
    }

}