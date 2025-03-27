<?php

class CartController
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

        require_once '../Model/UserProducts.php';
        $user_products = new UserProducts();
        $data = $user_products->getCountByUserId($user_id);

        if ($data['count'] > 0) { // проверка количества заказов у пользователя

            $data = $user_products->getByUserId($user_id);

            foreach ($data as $product) {  // достаем описание каждого продукта из бд products

                $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');

                $oprst = $pdo->prepare("SELECT name,description,price,image_url FROM products WHERE id = :id ");
                $oprst->execute(['id' => $product['product_id']]);
                $data1 = $oprst->fetch();
                //print_r($data1);
                $final = array_merge($product, $data1);
                $list[] = array_merge($final, $data1);;

            }
        } else {
            $message = 'Корзина пуста';
        }

        require_once '../Views/cart.php';
    }
}