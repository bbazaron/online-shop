<?php

namespace Controllers;

use DTO\AddNewProductDTO;
use DTO\OrderCreateDTO;
use Model\Product;
use Model\Review;
use Model\User;
use Request\AddNewProductRequest;
use Request\ReviewRequest;

class ProductController extends BaseController
{
    private \Services\CartService $cartService;

    public function __construct()
    {
        parent::__construct();
        $this->authService = new \Services\Auth\AuthSessionService();
        $this->cartService = new \Services\CartService();
    }


    public function getCatalog()
    {
        if ($this->authService->check()===false) {
            header("Location: /login");
            exit;
        }
        $user = User::getRoleByEmail($this->authService->getCurrentUser()->getEmail());
        $role=$user->getRole();
        $products=Product::getAll();
        $sum=$this->cartService->getSum();
        $cartQuantity=$this->cartService->getQuantity();
        require_once '../Views/catalog.php';

    }


    public function getProductPage(array $errors=null)
    {
        $product=Product::getById($_POST['product_id']);
        $reviews=Review::getByProductId($product->getId());
        $arr=[];
        if ($reviews !== false) {
            foreach ($reviews as $review) {
                $data = $review->getRating();
                $arr[]=$data;
                $averageRating = array_sum($arr)/count($arr);
            }
        }
        $sum=$this->cartService->getSum();
        $cartQuantity=$this->cartService->getQuantity();

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

            $message = Review::create($product_id, $userId, $name, $rating, $comment);
            if ($message){
                echo "Отзыв отправлен";
            }
            $this->getProductPage();

        } else {
           $this->getProductPage($errors);
        }
    }

    public function productManagement()
    {
        $user = User::getRoleByEmail($this->authService->getCurrentUser()->getEmail());
        $role=$user->getRole();
        $sum=$this->cartService->getSum();
        $cartQuantity=$this->cartService->getQuantity();
        $products=Product::getAll();

        require_once '../Views/admin/product_management.php';
    }

    public function addNewProduct(AddNewProductRequest $request)
    {
        $errors = $request->validateProduct();
        if (empty($errors)) {

                $dto= new AddNewProductDTO(
                    $request->getName(),
                    $request->getPrice(),
                    $request->getImageUrl(),
                    $request->getDescription()
                );

        }
    }
}