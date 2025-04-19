<?php

namespace Services;

class CartService
{
    private \Model\UserProducts $userProducts;

    public function __construct()
    {
        $this->userProducts = new \Model\UserProducts();
    }

    public function addProduct(int $product_id, int $user_id, int $amount):string
    {

        $data = $this->userProducts->getByProductIdUserId($product_id,$user_id);

        if ($data === false) {
            $this->userProducts->insertToCart($user_id,$product_id,$amount);
            $message='Продукт добавлен';
            return $message;
        } else {
            $amount = $data['amount'] + 1;
            $this->userProducts->updateToCart($user_id,$product_id,$amount);
            $message='Продукт добавлен повторно';
            return $message;
        }
    }

    public function decreaseProduct(int $product_id, int $user_id):string
    {
        $data = $this->userProducts->getByProductIdUserId($product_id,$user_id);

        if ($data === false) {
            $message = "Продукта нет в корзине";
            return $message;

        } elseif($data['amount'] === 1) {
            $this->userProducts->deleteByUserIdProductId($user_id,$product_id);
            $message = "Продукт удален из корзины";
            return $message;
        }

        else {
            $amount = $data['amount'] - 1;
            $this->userProducts->updateToCart($user_id,$product_id,$amount);
            $message = "Количество продукта уменьшено";
            return $message;
        }
    }

}