<?php
namespace Controllers;
class CartController extends \Model\Model
{
    private \Model\Cart $cart;
    public function __construct()
    {
        $this->cart = new \Model\Cart();
    }

    public function getCart()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
            exit;
        }
        $list=$this->cart->getCart(); // достаем все продукты из корзины
        $sum=0;

//        echo"<pre>";
//        print_r($list);
        if ($list=== null) {
            $message = 'Корзина пуста';
        } else {
            foreach ($list as $product) {
                $sum+=$product['price']*$product['amount'];
            }
        }

        require_once '../Views/cart.php';
    }

}