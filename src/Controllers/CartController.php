<?php
namespace Controllers;
use Model\Product;
use Request\AddProductRequest;

class CartController extends BaseController
{
    private \Model\Cart $cart;
    private \Model\Product $product;
    private \Services\CartService $cartService;

    public function __construct()
    {
        parent::__construct();
        $this->cart = new \Model\Cart();
        $this->product = new \Model\Product();
        $this->cartService = new \Services\CartService();
    }

    public function getCart()
    {
        if ($this->authService->check()===false) {
            header("Location: /login");
            exit;
        }
        $list=$this->cart->getCart(); // достаем все продукты из корзины
        $sum=0;

        foreach ($list as $product) {
            $sum+=$product->getPrice()*$product->getAmount();
        }

        require_once '../Views/cart.php';
    }

    public function addProductToCart(AddProductRequest $request)
    {
        $user_id = $this->authService->getCurrentUser();
        $amount=1;

        $dto = new \DTO\AddProductDTO($request->getProductId(),$user_id,$amount);

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
        $user_id = $this->authService->getCurrentUser();
        $product_id = $_POST['product_id'];

        $dto = new \DTO\DecreaseProductDTO($product_id,$user_id,);

        $message = $this->cartService->decreaseProduct($dto);
//        echo $message;

        header("Location: /catalog");
        exit;
    }

}