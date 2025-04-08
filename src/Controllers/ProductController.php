<?php

namespace Controllers;

class ProductController
{
    private \Model\Product $product;
    private \Model\UserProducts $userProducts;
    public function __construct()
    {
        $this->product = new \Model\Product;
        $this->userProducts = new \Model\UserProducts;
    }
    public function getCatalog()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
            exit;
        }

        $products=$this->product->getAllProducts();
        require_once '../Views/catalog.php';

    }

    public function catalog()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
            exit;
        }


        $this->getCatalog();
    }

    public function validateProduct($post): array
    {
        $errors = [];

//        if (isset($post['product_id'])) {
//            $product_id = (int)$post['product_id'];
//
////            $data = $this->product->getById($product_id);
////
//////            if ($data === false) {
//////                $errors['product_id'] = $data;
//////            }
//        }


        if (isset($post['amount'])) {
            $amount = $post['amount'];
            if (is_numeric($amount) === false) {
                $errors['amount'] = "Введены неверные данные";
            } elseif ($amount === '0') {
                $errors['amount'] = "amount не может быть 0";
            }
        }
        return $errors;
    }

    public function addToCart()
    {
        $errors = $this->validateProduct($_POST);
        if (empty($errors)) {
            $userid = $_SESSION['userId'];
            $product_id = $_POST['product_id'];
            $amount = $_POST['amount'];

            $data = $this->userProducts->getByProductIdUserId($product_id,$userid);

            if ($data === false) {
                $message=$this->userProducts->insertToCart($userid,$product_id,$amount);
                echo $message;
            } else {
                $amount = $data['amount'] + $amount;

                $message=$this->userProducts->updateToCart($userid,$product_id,$amount);
                echo $message;

            }


        }
        $this->catalog();
    }

    public function removeFromCart()
    {

    }
}