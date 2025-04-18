<?php

namespace Controllers;

use Model\Review;

class ProductController extends BaseController
{
    private \Model\Product $product;
    private \Model\UserProducts $userProducts;
    private \Model\Review $reviewModel;
    public function __construct()
    {
        parent::__construct();
        $this->product = new \Model\Product;
        $this->userProducts = new \Model\UserProducts;
        $this->authService = new \Services\AuthService();
        $this->reviewModel = new Review();
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

    public function getProductPage(array $errors=null)
    {
        $product=$this->product->getById($_POST['product_id']);
        $reviews=$this->reviewModel->getByProductId($product->getId());
        $arr=[];
        if ($reviews !== false) {
            foreach ($reviews as $review) {
                $data = $review->getRating();
                $arr[]=$data;
                $averageRating = array_sum($arr)/count($arr);
            }
        }
        require_once "../Views/product_page.php";

    }

    public function validateReview($post): array
    {
        $errors = [];

        if (isset($post['name'])){
            $name = $post['name'];
            if (strlen($name) < 2) {
                $errors['name'] = 'Слишком короткое имя';
            }
        } else {
            $errors['name']='Имя должно быть заполнено';
        }

        if (isset($post['rating'])){
            $rating = $post['rating'];
            if (is_numeric($rating) === false) {
                $errors['rating']='Введите число';
            } elseif ($rating === '0') {
                $errors['rating']='Не может быть число 0';
            }

        } else {
            $errors['rating']='Поле должно быть заполнено';
        }

        if (isset($post['comment'])){
            $comment = $post['comment'];
            if (strlen($comment) < 2) {
                $errors['comment']='Недопустимая длина отзыва';
            }
        }

        return $errors;
    }
    public function createReview()
    {
        $errors = $this->validateReview($_POST);
        if (empty($errors)) {
            $userId = $_SESSION['userId'];
            $name = $_POST['name'];
            $rating = $_POST['rating'];
            $comment = $_POST['comment'];
            $product_id = $_POST['product_id'];
            $data = $this->reviewModel->create($product_id, $userId, $name, $rating, $comment);
            print_r($data);
            $this->getProductPage();

        } else {
           $this->getProductPage($errors);
        }
    }


}