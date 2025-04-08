<?php

namespace Controllers;

use Model\Cart;
use Model\Order;
use Model\Product;
use Model\UserProducts;
use Model\OrderProducts;

class OrderController extends \Model\Model
{
    private Cart $cartModel;
    private Order $orderModel;
    private Product $productModel;
    private UserProducts $userProductsModel;
    private OrderProducts $orderProductsModel;

    public function __construct()
    {
        $this->cartModel = new Cart();
        $this->orderModel = new Order();
        $this->productModel = new Product();
        $this->userProductsModel = new UserProducts();
        $this->orderProductsModel = new OrderProducts();
    }

    public function getOrders()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
            exit;
        }

        $userOrders = $this->orderModel->getAllByUserId($_SESSION['userId']);
        $allUserOrders = [];
        $sum=0;
//        echo"<pre>";print_r($userOrders);exit;
        foreach ($userOrders as $userOrder) { // class OrderProducts

            $orderProducts = $this->orderProductsModel->getAllByOrderId($userOrder->getId());
//        echo"<pre>";print_r($orderProducts);exit;

            $newOrderProducts = [];
            $sum=0;

            foreach ($orderProducts as $orderProduct) {  // class OrderProducts
                $product = $this->productModel->getById($orderProduct->getProductId());
//                echo"<pre>";print_r($product);exit;
                $orderProduct->setProduct($product->getName());
                $orderProduct->setDescription($product->getDescription());
                $orderProduct->setPrice($product->getPrice());
                $orderProduct->setImageUrl($product->getImageUrl());
                $orderProduct->setTotalSum($product->getPrice() * $orderProduct->getAmount());

//                $orderProduct['description'] = $product->getDescription();
//                $orderProduct['price'] = $product->getPrice();
//                $orderProduct['image_url'] = $product->getImageUrl();
//                $orderProduct['totalSum'] = $orderProduct['price'] * $orderProduct['amount'];

//                $sum=$sum+$orderProduct['totalSum'];

                $newOrderProducts[] = $orderProduct; //class OrderProducts
//                $userOrder->setTotalSum($orderProduct->getTotalSum());
            }


            $userOrder->setOrderProducts($newOrderProducts);
            echo"<pre>";print_r($userOrder);exit;
            $allUserOrders[] = $userOrder;
        }

//        print_r($allUserOrders);

        require_once '../Views/userOrders.php';
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

        $list=$this->cartModel->getCart(); // достаем все продукты из корзины
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

            $orderId = $this->orderModel->create($name, $phoneNumber, $address, $comment, $userId); // вводим данные заказа в таблицу

            $userProducts = $this->userProductsModel->getAllByUserId($userId); // достаем все продукты из корзины


            if (isset($userProducts)) {

                foreach ($userProducts as $userProduct) { // вносим данные каждого товара из корзины в order_products
                    $this->orderProductsModel->create($orderId, $userProduct["product_id"], $userProduct["amount"]);
                }

                $this->userProductsModel->deleteByUserId($userId); // очистка корзины

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