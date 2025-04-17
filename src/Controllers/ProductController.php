<?php

namespace Controllers;

class ProductController extends BaseController
{
    private \Model\Product $product;
    private \Model\UserProducts $userProducts;
    public function __construct()
    {
        parent::__construct();
        $this->product = new \Model\Product;
        $this->userProducts = new \Model\UserProducts;
        $this->authService = new \Services\AuthService();
    }


    public function getCatalog()
    {
        if ($this->authService->check()===false) {
            header("Location: /login");
            exit;
        }
        $products=$this->product->getAllProducts();
        require_once '../Views/catalog.php';

    }

    public function validateProduct($post): array
    {
        $errors = [];

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
            $user_id = $this->authService->getCurrentUser();
//            echo"<pre>";print_r($user_id);exit;
            $product_id = $_POST['product_id'];
            $amount=1;
            $data = $this->userProducts->getByProductIdUserId($product_id,$user_id->getId());

            if ($data === false) {
                $message=$this->userProducts->insertToCart($user_id->getId(),$product_id,$amount);
                echo $message;
            } else {
                $amount = $data['amount'] + 1;

                $message=$this->userProducts->updateToCart($user_id->getId(),$product_id,$amount);
                echo $message;

            }
        $this->getCatalog();
    }

    public function decreaseFromCart()
    {
            $user_id = $this->authService->getCurrentUser();
            $product_id = $_POST['product_id'];

            $data = $this->userProducts->getByProductIdUserId($product_id,$user_id->getId());

            if ($data === false) {
                echo "Продукта нет в корзине";
                
            } elseif($data['amount'] === 1) {
                $this->userProducts->deleteByUserIdProductId($user_id->getId(),$product_id);
                echo "Продукт удален из корзины";
            }
                else {
                    $amount = $data['amount'] - 1;
                    $this->userProducts->updateToCart($user_id->getId(),$product_id,$amount);
                    echo "Количество продукта уменьшено";

                }
        $this->getCatalog();
    }
}