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

                $data1 = $product->getById($prod['product_id']);
                //print_r($data1);
                $final = array_merge($prod, $data1); // объединение массивов друг за другом
                $list[] = array_merge($final, $data1);
            }
//            echo "<pre>";
//            print_r($list);

        }
        return $list;
    }
}