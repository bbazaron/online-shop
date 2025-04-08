<?php

namespace Model;

class Cart extends \Model\Model
{
    public function getCart():array|null
    {
        $user_id = $_SESSION['userId'];

        $user_products = new \Model\UserProducts();
        $data = $user_products->getCountByUserId($user_id);

        $list=null;
        if ($data['count'] > 0) { // проверка количества заказов у пользователя

            $data = $user_products->getAllByUserId($user_id);
            $product = new \Model\Product();
            foreach ($data as $prod) {  // достаем описание каждого продукта из бд products

                $products = $product->getById($prod['product_id']);

                $data1=[];
                $data1['name']=$products->getName();
                $data1['price']=$products->getPrice();
                $data1['image_url']=$products->getImageUrl();
                if ($products->getDescription()!==null) { // описание не обязательное
                    $data1['description']=$products->getDescription();
                } else {
                    $data1['description']=null;
                }

                $list[] = array_merge($prod, $data1);
            }

        }
        return $list;
    }
}