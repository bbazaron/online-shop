<?php
namespace Controllers;
class CartController extends \Model\Model
{

    public function getCart()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
            exit;
        }
        $cart = new \Model\Cart();
        $list = $cart->getCart();
//        echo"<pre>";
//        print_r($list);
        if ($list=== null) {
            $message = 'Корзина пуста';
        }

        require_once '../Views/cart.php';

    }

}