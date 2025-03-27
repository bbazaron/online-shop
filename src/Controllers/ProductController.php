<?php

class ProductController
{
    public function getCatalog()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
            exit;
        }
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

        require_once '../Model/Product.php';
        $productModel = new Product();
        $products = $productModel->getAllProducts();

        $this->getCatalog();
    }

    public function validateProduct($post): array
    {
        $errors = [];

        if (isset($post['product_id'])) {
            $product_id = (int)$post['product_id'];
            require_once '../Model/Product.php';
            $productModel = new Product();
            $data = $productModel->getById($product_id);

            if ($data === false) {
                $errors['product_id'] = $data;
            }
        }


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

            require_once '../Model/Product.php';
            $productModel = new UserProducts();
            $data = $productModel->getByProductIdUserId($product_id,$userid);

            if ($data === false) {
                $message=$productModel->insertToCart($userid,$product_id,$amount);
                echo $message;
            } else {
                $amount = $data['amount'] + $amount;

                $message=$productModel->updateToCart($userid,$product_id,$amount);
                echo $message;

            }


        }
        $this->catalog();
    }
}