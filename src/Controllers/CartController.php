<?php
namespace Controllers;
use Model\Product;
use Request\AddProductRequest;

class CartController extends BaseController
{
    private \Services\CartService $cartService;

    public function __construct()
    {
        parent::__construct();
        $this->cartService = new \Services\CartService();
    }

    public function getCart()
    {
        if ($this->authService->check()===false) {
            header("Location: /login");
            exit;
        }

        $list=$this->cartService->getUserProducts(); // достаем все продукты из корзины

        $sum = $this->cartService->getSum();

        require_once '../Views/cart.php';
    }

    public function addProductToCart(AddProductRequest $request)
    {
        $amount=1; // увеличиваем кол-во на 1

        $dto = new \DTO\AddProductDTO($request->getProductId(),$amount);

        $message = $this->cartService->addProduct($dto);
//        if ($message) {
//            echo "Продукт добавлен";
//        } else {
//            echo "Продукт добавлен повторно";
//        }

        header("Location:/catalog");
        exit;
    }


    public function decreaseProductFromCart()
    {
        $product_id = $_POST['product_id'];

        $dto = new \DTO\DecreaseProductDTO($product_id);

        $message = $this->cartService->decreaseProduct($dto);
//        echo $message;

        header("Location: /catalog");
        exit;
    }

}