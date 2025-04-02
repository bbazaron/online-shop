<?php
namespace Controllers;
class CartController extends \Model\Model
{
    public function getCart()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
            exit;
        }

        $user_id = $_SESSION['userId'];

        $user_products = new \Model\UserProducts();
        $data = $user_products->getCountByUserId($user_id);

        if ($data['count'] > 0) { // проверка количества заказов у пользователя

            $data = $user_products->getByUserId($user_id);
            $product = new \Model\Product();
            foreach ($data as $prod) {  // достаем описание каждого продукта из бд products

                $data1 = $product->getById($prod['product_id']);
                //print_r($data1);
                $final = array_merge($prod, $data1); // объединение массивов друг за другом
                $list[] = array_merge($final, $data1);

            }
        } else {
            $message = 'Корзина пуста';
        }

        require_once '../Views/cart.php';
    }

}