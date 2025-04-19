<?php

namespace Services;
use \Model\Order;
use \Model\UserProducts;
use \Model\OrderProducts;
use \Model\Product;
class OrderService
{
    private Order $orderModel;
    private UserProducts $userProductsModel;
    private OrderProducts $orderProductsModel;
    private Product $productModel;

    public function __construct()
    {
        $this->orderModel = new Order();
        $this->userProductsModel = new UserProducts();
        $this->orderProductsModel = new OrderProducts();
        $this->productModel = new Product();
    }
    public function createOrder(string $name, string $phoneNumber, string $address, string|null $comment, int $userId):string
    {
        $orderId = $this->orderModel->create($name, $phoneNumber, $address, $comment, $userId); // вводим данные заказа в таблицу

        $userProducts = $this->userProductsModel->getAllByUserId($userId); // достаем все продукты из корзины

        if (isset($userProducts)) {

            foreach ($userProducts as $userProduct) { // вносим данные каждого товара из корзины в order_products
                $this->orderProductsModel->create($orderId, $userProduct->getProductId(), $userProduct->getAmount());
            }

            $this->userProductsModel->deleteByUserId($userId); // очистка корзины

            $message = "Заказ оформлен";
            return $message;

        } else {
            $message = "Корзина пуста";
            return $message;
        }
    }

}