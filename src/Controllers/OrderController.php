<?php

namespace Controllers;

use DTO\OrderCreateDTO;
use http\Header;
use Model\Cart;
use Model\Order;
use Model\Product;
use Model\OrderProducts;
use Request\OrderRequest;
use Services\OrderService;

class OrderController extends BaseController
{
    private Cart $cartModel;
    private Order $orderModel;

    private Product $productModel;
    private OrderProducts $orderProductsModel;
    private OrderService $orderService;




    public function __construct()
    {
        parent::__construct();
        $this->cartModel = new Cart();
        $this->orderModel = new Order();
        $this->productModel = new Product();
        $this->orderProductsModel = new OrderProducts();
        $this->orderService = new OrderService();
    }

    public function getOrders()
    {
        if ($this->authService->check()===false) {
            header("Location: /login");
            exit;
        }
        $userOrders = $this->orderModel->getAllByUserId($this->authService->getCurrentUser()->getId());

        $allUserOrders = [];
        $sum=0;

        foreach ($userOrders as $userOrder) {

            $orderProducts = $this->orderProductsModel->getAllByOrderId($userOrder->getId());

            $newOrderProducts = [];
            $sum=0;
            foreach ($orderProducts as $orderProduct) {
                $product = $this->productModel->getById($orderProduct->getProductId());

                $orderProduct->setProduct($product->getName());
                $orderProduct->setDescription($product->getDescription());
                $orderProduct->setPrice($product->getPrice());
                $orderProduct->setImageUrl($product->getImageUrl());
                $orderProduct->setTotalSum($product->getPrice() * $orderProduct->getAmount());

                $sum=$sum+$orderProduct->getTotalSum();

                $newOrderProducts[] = $orderProduct;
            }
            $userOrder->setOrderProducts($newOrderProducts);

            $userOrder->setTotalSum($sum);
            $allUserOrders[] = $userOrder;

        }

        require_once '../Views/userOrders.php';
    }

    public function getCheckOutForm(array $errors=null)
    {
        if ($this->authService->check()===false) {
            header("Location: /login");
            exit;
        }

        $list=$this->cartModel->getCart(); // достаем все продукты из корзины
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
            $userId = $this->authService->getCurrentUser();
            $dto= new OrderCreateDTO(
                $request->getName(),
                $request->getPhone(),
                $request->getAddress(),
                $request->getComment(),
                $userId);


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