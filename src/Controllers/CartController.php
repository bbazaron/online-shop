<?php
namespace Controllers;
class CartController extends BaseController
{
    private \Model\Cart $cart;
    public function __construct()
    {
        parent::__construct();
        $this->cart = new \Model\Cart();
        $this->authService = new \Services\AuthService();
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

}