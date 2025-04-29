<?php

namespace Controllers;

use DTO\OrderCreateDTO;
use http\Header;
use Model\Cart;
use Request\OrderRequest;
use Services\CartService;
use Services\OrderService;

class OrderController extends BaseController
{
    private OrderService $orderService;
    private CartService $cartService;

    public function __construct()
    {
        parent::__construct();
        $this->orderService = new OrderService();
        $this->cartService = new CartService();
    }

    public function getOrders()
    {
        if ($this->authService->check()===false) {
            header("Location: /login");
            exit;
        }

        $allUserOrders = $this->orderService->getAll();

        require_once '../Views/userOrders.php';
    }

    public function getCheckOutForm(array $errors=null)
    {
        if ($this->authService->check()===false) {
            header("Location: /login");
            exit;
        }

        $list=$this->cartService->getUserProducts(); // достаем все продукты из корзины
        $sum=0;
        foreach ($list as $product) {
            $sum+=$product->getPrice()*$product->getAmount();
        }

        require_once '../Views/order_form.php';
    }


    public function handleCheckOut(OrderRequest $request)
    {
        $errors = $request->orderValidation();

        if (empty($errors)) {

//            if (isset ($_POST['comment'])) { // comment не обязателен в форме
//                $comment = $_POST['comment'];
//            } else {
//                $comment = null;
//            }

            $dto= new OrderCreateDTO(
                $request->getName(),
                $request->getPhone(),
                $request->getAddress(),
                $request->getComment(),
                );


            $this->orderService->createOrder($dto);
//            $message =
//            if ($message) {
//                echo 'Заказ оформлен';
//            } else {
//                echo 'Корзина пуста';
//            }

            header('Location: /catalog');
            exit;

        } else {
            $this->getCheckOutForm($errors);
        }
    }
}