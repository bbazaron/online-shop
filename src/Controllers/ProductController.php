<?php

namespace Controllers;

use DTO\AddNewProductDTO;
use DTO\DeleteProductDTO;
use DTO\OrderCreateDTO;
use DTO\EditProductDTO;
use Model\Product;
use Model\Review;
use Model\User;
use Request\AddNewProductRequest;
use Request\EditProductRequest;
use Request\ReviewRequest;
use Services\CartService;
use Services\ProductService;

class ProductController extends BaseController
{
    private CartService $cartService;
    private ProductService $productService;

    public function __construct()
    {
        parent::__construct();
        $this->authService = new \Services\Auth\AuthSessionService();
        $this->cartService = new CartService();
        $this->productService = new ProductService();
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

    public function getProductManagement(array $errors=null)
    {
        $user = User::getRoleByEmail($this->authService->getCurrentUser()->getEmail());
        $role=$user->getRole();
        $sum=$this->cartService->getSum();
        $cartQuantity=$this->cartService->getQuantity();
        $products=Product::getAll();
//        echo"<pre>";print_r($products);exit;

        require_once '../Views/admin/product_management.php';
    }

    public function addNewProduct(AddNewProductRequest $request)
    {
//        echo"<pre>";print_r($request);exit;
        $errors = $request->validateProduct();
        if (empty($errors)) {

                $dto= new AddNewProductDTO(
                    $request->getName(),
                    $request->getPrice(),
                    $request->getImageUrl(),
                    $request->getDescription()
                );

                $this->productService->addNewProduct($dto);
        }
        $this->getProductManagement($errors);
    }

    public function deleteProduct(\Request\DeleteProductRequest $request)
    {
        $productId = $request->getProductId();
        $dto = new DeleteProductDTO($productId);
        $this->productService->deleteProduct($dto);
        header("Location: /product-management");
        exit;
    }

    public function editProduct(EditProductRequest $request)
    {
//        echo "<pre>";
//        print_r($request);
//        exit;
        $errors = $request->validateProduct();
        if (empty($errors)) {
            $id = $request->getId();
            $name = $request->getName();
            $description = $request->getDescription();
            $price = $request->getPrice();
            $image_url = $request->getImageUrl();

            if ($name !== "") {
                Product::updateNameById($id, $name);
            }
            if ($description !== "") {
                Product::updateDescriptionById($id, $description);
            }
            if ($price !== "") {
                Product::updatePriceById($id, $price);
            }
            if ($image_url !== "") {
                Product::updateImageUrlById($id, $image_url);
            }

            header("Location: /product-management");
            exit;
        } else {
            $this->getProductManagement($errors);
        }

    }
}