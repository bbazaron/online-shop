<?php

namespace Controllers;

use Model\Review;
use Request\ReviewRequest;

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


//    public function decreaseFromCart()
//    {
//            $user_id = $this->authService->getCurrentUser();
//            $product_id = $_POST['product_id'];
//
//            $data = $this->userProducts->getByProductIdUserId($product_id,$user_id->getId());
//
//            if ($data === false) {
//                echo "Продукта нет в корзине";
//
//            } elseif($data['amount'] === 1) {
//                $this->userProducts->deleteByUserIdProductId($user_id->getId(),$product_id);
//                echo "Продукт удален из корзины";
//            }
//                else {
//                    $amount = $data['amount'] - 1;
//                    $this->userProducts->updateToCart($user_id->getId(),$product_id,$amount);
//                    echo "Количество продукта уменьшено";
//                }
//        $this->getCatalog();
//    }

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

    public function createReview(ReviewRequest $request)
    {
        $errors = $request->validateReview();
        if (empty($errors)) {

            $product_id = $request->getProductId();
            $userId = $_SESSION['userId'];
            $name = $request->getName();
            $rating = $request->getRating();
            $comment = $request->getComment();

            $message = $this->reviewModel->create($product_id, $userId, $name, $rating, $comment);
            if ($message){
                echo "Отзыв отправлен";
            }
            $this->getProductPage();

        } else {
           $this->getProductPage($errors);
        }
    }


}