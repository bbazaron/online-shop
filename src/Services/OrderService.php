<?php

namespace Services;
use DTO\OrderCreateDTO;
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
    public function createOrder(OrderCreateDTO $dto):bool
    {
        $orderId = $this->orderModel->create(
                                            $dto->getName(),
                                            $dto->getPhone(),
                                            $dto->getAddress(),
                                            $dto->getComment(),
                                            $dto->getUser()->getId()
                                            );                          // вводим данные заказа в таблицу


        $userProducts = $this->userProductsModel->getAllByUserId($dto->getUser()->getId()); // достаем все продукты из корзины

        if (isset($userProducts)) {

            foreach ($userProducts as $userProduct) { // вносим данные каждого товара из корзины в order_products
                $this->orderProductsModel->create($orderId, $userProduct->getProductId(), $userProduct->getAmount());
            }

            $this->userProductsModel->deleteByUserId($dto->getUser()->getId()); // очистка корзины

            return true;
        } else {
            return false;
        }
    }

}