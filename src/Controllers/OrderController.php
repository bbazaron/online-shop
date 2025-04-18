<?php

namespace Controllers;

use Model\Cart;
use Model\Order;
use Model\Product;
use Model\OrderProducts;
use Services\OrderService;

class OrderController extends BaseController
{
    private Cart $cartModel;
    private Order $orderModel;

    private Product $productModel;
    private OrderProducts $orderProductsModel;
    private OrderService $orderService;



    public function __construct()
    {
        parent::__construct();
        $this->cartModel = new Cart();
        $this->orderModel = new Order();
        $this->productModel = new Product();
        $this->orderProductsModel = new OrderProducts();
        $this->orderService = new OrderService();
    }

    public function getOrders()
    {
        if ($this->authService->check()===false) {
            header("Location: /login");
            exit;
        }
        $userOrders = $this->orderModel->getAllByUserId($this->authService->getCurrentUser()->getId());

        $allUserOrders = [];
        $sum=0;

        foreach ($userOrders as $userOrder) {

            $orderProducts = $this->orderProductsModel->getAllByOrderId($userOrder->getId());

            $newOrderProducts = [];
            $sum=0;
            foreach ($orderProducts as $orderProduct) {
                $product = $this->productModel->getById($orderProduct->getProductId());

                $orderProduct->setProduct($product->getName());
                $orderProduct->setDescription($product->getDescription());
                $orderProduct->setPrice($product->getPrice());
                $orderProduct->setImageUrl($product->getImageUrl());
                $orderProduct->setTotalSum($product->getPrice() * $orderProduct->getAmount());

                $sum=$sum+$orderProduct->getTotalSum();

                $newOrderProducts[] = $orderProduct;
            }
            $userOrder->setOrderProducts($newOrderProducts);

            $userOrder->setTotalSum($sum);
            $allUserOrders[] = $userOrder;

        }

        require_once '../Views/userOrders.php';
    }

    public function getCheckOutForm(array $errors=null)
    {
        if ($this->authService->check()===false) {
            header("Location: /login");
            exit;
        }

        $list=$this->cartModel->getCart(); // достаем все продукты из корзины
        $sum=0;
        foreach ($list as $product) {
            $sum+=$product->getPrice()*$product->getAmount();
        }

        require_once '../Views/order_form.php';
    }

    private function orderValidation($post):array
    {
        if ($this->authService->check()===false) {
            header("Location: /login");
            exit;
        }
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
                $errors['address'] = "Адрес должен содержать больше 2 символов";
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
                $comment = null;
            }
            $message = $this->orderService->createOrder($name,$phoneNumber,$address,$comment,$userId);
            echo $message;

            $products=$this->productModel->getAllProducts();
            require_once '../Views/catalog.php';

        } else {
            $this->getCheckOutForm($errors);
        }
    }
}