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
        $dto = new \DTO\AddProductDTO($request->getProductId(),$request->getAmount());

        $message = $this->cartService->addProduct($dto);
//        if ($message) {
//            echo "Продукт добавлен";
//        } else {
//            echo "Продукт добавлен повторно";
//        }

        header("Location:/cart");
        exit;
    }


    public function decreaseProductFromCart(AddProductRequest $request)
    {

        $dto = new \DTO\DecreaseProductDTO($request->getProductId(),$request->getAmount());

        $message = $this->cartService->decreaseProduct($dto);
//        echo $message;

        header("Location: /cart");
        exit;
    }

}