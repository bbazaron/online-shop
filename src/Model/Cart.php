<?php

namespace Model;

class Cart extends \Model\Model
{
    public function getCart():array|null
    {
        $user_id = $_SESSION['userId'];

        $user_products = new \Model\UserProducts();
        $count = $user_products->getCountByUserId($user_id);

        $allProducts=[];
        if ($count->getCount() > 0) { // проверка количества заказов у пользователя

            $productModel = new \Model\Product();
            $userProducts = $user_products->getAllByUserId($user_id);
            foreach ($userProducts as $userProduct) {  // достаем описание каждого продукта из бд product

                $product = $productModel->getById($userProduct->getProductId());
                $product->setAmount($userProduct->getAmount());
                $allProducts[] = $product;

            }
        }
        return $allProducts;
    }


}