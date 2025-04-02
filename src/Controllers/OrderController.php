<?php

namespace Controllers;

use Model\UserProducts;

class OrderController extends \Model\Model
{
    public function getOrderForm(array $errors=null)
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
            exit;
        }
        require_once '../Views/order_form.php';
    }

    private function orderValidation($post):array
    {
        $errors = [];

        if (isset($post['name'])) {
            $name = $post['name'];

            if (strlen($name) < 2) {
                $errors['name'] = "Имя должно содержать больше 2 символов";
            }
        } else {
            $errors['name'] = "Имя должно быть заполнено";
        }

        if (isset($post['phoneNumber'])) {
            $phoneNumber = $post['phoneNumber'];
            if (is_numeric($phoneNumber) === false) {
                $errors['phoneNumber'] = "Введены неверные данные";
            } elseif ($phoneNumber === '0') {
                $errors['phoneNumber'] = "номер не может быть 0";
            }
        } else {
            $errors['phoneNumber'] = 'номер должен быть заполнен';
        }

        if (isset($post['address'])) {
            $address = $post['address'];

            if (strlen($address) < 2) {
                $errors['address'] = "Адрес должен содержать больше 2 символов";
            }
        } else {
            $errors['address'] = "Адрес должен быть заполнен";
        }


        return $errors;
    }
    public function handleOrder()
    {
        $errors = $this->orderValidation($_POST);

        if (empty($errors)) {

            $userId = $_SESSION['userId'];
            $name = $_POST['name'];
            $phoneNumber = $_POST['phoneNumber'];
            $address = $_POST['address'];


            $order = new \Model\Order();
            $order->insert($userId, $name, $phoneNumber, $address); // вводим данные заказа в таблицу
            $orderId = $order->getIdByUserId($userId); // id нужен для внесения данных в order_products

            $userProducts = new \Model\UserProducts();
            $products = $userProducts->getByUserId($userId); // достаем все продукты из корзины


            $orderProducts = new \Model\OrderProducts();

            foreach ($products as $product) { // вносим данные каждого товара из корзины в order_products
                $orderProducts->insert($orderId[0], $userId, $product["product_id"], $product["amount"]);
            }

            $userProducts ->deleteFromCart($userId); // очистка корзины
//            echo "<pre>";
            require_once '../Views/cart.php';
//            print_r($products);
//            print_r($orderId);


            echo "\n Заказ оформлен";
        } else {
            $this->getOrderForm($errors);
        }
    }
}