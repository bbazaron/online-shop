<?php

namespace Services;

class CartService
{
    private \Model\UserProducts $userProducts;
    private \Model\Product $productModel;
    private \Model\UserProducts $userProductsModel;
    private Auth\AuthInterface $authService;

    public function __construct()
    {
        $this->userProducts = new \Model\UserProducts();
        $this->productModel = new \Model\Product();
        $this->userProductsModel = new \Model\UserProducts();
        $this->authService = new Auth\AuthSessionService();
    }

    public function addProduct(\DTO\AddProductDTO $dto):string
    {

        $user = $this->authService->getCurrentUser();

        $data = $this->userProducts->getByProductIdUserId($dto->getProductId(), $user->getId());

        if ($data === false) {
            $this->userProducts->insertToCart($user->getId(), $dto->getProductId(), $dto->getAmount());
            return true;
        } else {
            $amount = $dto->getAmount() + 1;
            $this->userProducts->updateToCart($user->getId(), $dto->getProductId(), $amount);
            return false;
        }
    }

    public function decreaseProduct(\DTO\DecreaseProductDTO $dto):string
    {
        $user=$this->authService->getCurrentUser();

        $data = $this->userProducts->getByProductIdUserId($dto->getProductId(), $user->getId());

        if ($data === false) {
            $message = "Продукта нет в корзине";
            return $message;

        } elseif($data['amount'] === 1) {
            $this->userProducts->deleteByUserIdProductId($user->getId(), $dto->getProductId());
            $message = "Продукт удален из корзины";
            return $message;
        }

        else {
            $amount = $data['amount'] - 1;
            $this->userProducts->updateToCart($user->getId(), $dto->getProductId(),$amount);
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

        $count = $this->userProductsModel->getCountByUserId($user->getId());

        $allProducts=[];
        if ($count->getCount() > 0) { // проверка количества заказов у пользователя

            $userProducts = $this->userProductsModel->getAllByUserId($user->getId());

            foreach ($userProducts as $userProduct) {  // достаем описание каждого продукта из бд product

                $product = $this->productModel->getById($userProduct->getProductId());
                $product->setAmount($userProduct->getAmount());
                $allProducts[] = $product;
            }

        }
        return $allProducts;
    }

}