<?php
namespace Controllers;
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

    public function addProductToCart()
    {
        $user_id = $this->authService->getCurrentUser();
        $product_id = $_POST['product_id'];
        $amount=1;

        $message = $this->cartService->addProduct($product_id, $user_id->getId(), $amount);
        echo $message;

        $products=$this->product->getAllProducts();
        require_once '../Views/catalog.php';
    }


    public function decreaseProductFromCart()
    {
        $user_id = $this->authService->getCurrentUser();
        $product_id = $_POST['product_id'];

        $message = $this->cartService->decreaseProduct($product_id, $user_id->getId());
        echo $message;

        $products=$this->product->getAllProducts();
        require_once '../Views/catalog.php';
    }

}