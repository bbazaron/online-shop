<?php

namespace Controllers;

use Model\UserProducts;

class OrderController extends \Model\Model
{
    private \Model\Cart $cart;
    private \Model\Order $order;
    private \Model\UserProducts $userProducts;
    private \Model\OrderProducts $orderProducts;

    public function __construct()
    {
        $this->cart = new \Model\Cart();
        $this->order = new \Model\Order();
        $this->userProducts = new \Model\UserProducts();
        $this->orderProducts = new \Model\OrderProducts();
    }

    public function getOrders()
    {
        $order = $this->order->getAllByUserId($_SESSION['userId']);
        echo "<pre    >";
        print_r($order);

        $orderProducts = $this->orderProducts->getAllByOrderId($order[0]['id']);
        require_once '../Views/orders.php';
    }

    public function getCheckOutForm(array $errors=null)
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
            exit;
        }

        $list=$this->cart->getCart(); // достаем все продукты из корзины
        $sum=0;
        foreach ($list as $product) {
            $sum+=$product['price']*$product['amount'];
        }

        require_once '../Views/order_form.php';
    }

    private function orderValidation($post):array
    {
        $errors = [];

        if (isset($post['contact_name'])) {
            $name = $post['contact_name'];

            if (strlen($name) < 2) {
                $errors['contact_name'] = "Имя должно содержать больше 2 символов";
            }
        } else {
            $errors['contact_name'] = "Имя должно быть заполнено";
        }

        if (isset($post['contact_phone'])) {
            $contact_phone = $post['contact_phone'];
            if (is_numeric($contact_phone) === false) {
                $errors['contact_phone'] = "Введены неверные данные";
            } elseif ($contact_phone === '0') {
                $errors['contact_phone'] = "номер не может быть 0";
            } elseif(strlen($contact_phone)<2)
            {
                $errors['contact_phone'] = 'номер должен содержать большей 2 символов';
            }
        } else {
            $errors['contact_phone'] = 'номер должен быть заполнен';
        }

        if (isset($post['address'])) {
            $address = $post['address'];

            if (strlen($address) < 2) {
                $errors['address'] = "Имя должно содержать больше 2 символов";
            }
        } else {
            $errors['address'] = "Адрес должен быть заполнен";
        }

        return $errors;
    }
    public function handleCheckOut()
    {
        $errors = $this->orderValidation($_POST);

        if (empty($errors)) {

            $name = $_POST['contact_name'];
            $phoneNumber = $_POST['contact_phone'];
            $address = $_POST['address'];
            $userId = $_SESSION['userId'];

            if (isset ($_POST['comment'])) { // comment не обязателен в форме
                $comment = $_POST['comment'];
            } else {
                $comment = '';
            }

            $orderId = $this->order->create($name, $phoneNumber, $address, $comment, $userId); // вводим данные заказа в таблицу

            $userProducts = $this->userProducts->getAllByUserId($userId); // достаем все продукты из корзины


            if (isset($userProducts)) {

                foreach ($userProducts as $userProduct) { // вносим данные каждого товара из корзины в order_products
                    $this->orderProducts->create($orderId, $userProduct["product_id"], $userProduct["amount"]);
                }

                $this->userProducts->deleteByUserId($userId); // очистка корзины

//            echo "<pre>";
//            print_r($products);
//            print_r($orderId);

            require_once '../Views/cart.php';
                echo "\n Заказ оформлен";
            }
        } else {
            $this->getCheckOutForm($errors);
        }
    }
}