<?php

namespace Services;

use Model\Product;
use Model\User;
use Model\UserProducts;

class CartService
{
    private Auth\AuthInterface $authService;

    public function __construct()
    {
        $this->authService = new Auth\AuthSessionService();
    }

    public function addProduct(\DTO\AddProductDTO $dto):string
    {

        $user = $this->authService->getCurrentUser();

        $data = UserProducts::getByProductIdUserId($dto->getProductId(), $user->getId());

        if ($data === false) {
            UserProducts::insertToCart($user->getId(), $dto->getProductId(), $dto->getAmount());
            return true;
        } else {
            $newAmount = $data['amount'] + $dto->getAmount();
            UserProducts::updateToCart($user->getId(), $dto->getProductId(), $newAmount);
            return false;
        }
    }

    public function decreaseProduct(\DTO\DecreaseProductDTO $dto):string
    {
        $user=$this->authService->getCurrentUser();

        $data = UserProducts::getByProductIdUserId($dto->getProductId(), $user->getId());

        if ($data === false) {
            $message = "Продукта нет в корзине";
            return $message;

        } elseif($data['amount'] === 1) {
            UserProducts::deleteByUserIdProductId($user->getId(), $dto->getProductId());
            $message = "Продукт удален из корзины";
            return $message;
        }

        else {
            $newAmount = $data['amount'] - 1;
            UserProducts::updateToCart($user->getId(), $dto->getProductId(),$newAmount);
            $message = "Количество продукта уменьшено";
            return $message;
        }
    }

    public function getUserProducts():array|null
    {
        $user=$this->authService->getCurrentUser();

        if ($user == null) {
            return [];
        }

        $count = UserProducts::getCountByUserId($user->getId());
        $userProducts = UserProducts::getAllByUserIdWithProducts($user->getId());
        $allProducts=[];
        if ($count->getCount() > 0) { // проверка количества продуктов в корзине


            foreach ($userProducts as $userProduct) {  // достаем описание каждого продукта из бд product

                $product = Product::getById($userProduct->getProductId());
                $product->setAmount($userProduct->getAmount());
                $allProducts[] = $product;
            }

        }
        return $allProducts;
    }

    public function getSum():int|float
    {
        $list=$this->getUserProducts(); // достаем все продукты из корзины

        $sum=0;

        foreach ($list as $product) {
            $sum+=$product->getPrice()*$product->getAmount();
        }

        return $sum;
    }

}