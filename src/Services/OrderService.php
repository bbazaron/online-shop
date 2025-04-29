<?php

namespace Services;
use DTO\OrderCreateDTO;
use Model\Order;
use Model\OrderProducts;
use Model\Product;
use Model\UserProducts;
use Services\Auth\AuthInterface;
use Services\Auth\AuthSessionService;

class OrderService
{
    private Order $orderModel;
    private UserProducts $userProductsModel;
    private OrderProducts $orderProductsModel;
    private Product $productModel;

    private AuthInterface $authService;

    public function __construct()
    {
        $this->orderModel = new Order();
        $this->userProductsModel = new UserProducts();
        $this->orderProductsModel = new OrderProducts();
        $this->productModel = new Product();
        $this->authService = new AuthSessionService();
    }
    public function createOrder(OrderCreateDTO $dto):bool
    {
        $user = $this->authService->getCurrentUser();

        $orderId = $this->orderModel->create(
                                            $dto->getName(),
                                            $dto->getPhone(),
                                            $dto->getAddress(),
                                            $dto->getComment(),
                                            $user->getId()
                                            );                          // вводим данные заказа в таблицу


        $userProducts = $this->userProductsModel->getAllByUserId($user->getId()); // достаем все продукты из корзины

        if (isset($userProducts)) {

            foreach ($userProducts as $userProduct) { // вносим данные каждого товара из корзины в order_products
                $this->orderProductsModel->create($orderId, $userProduct->getProductId(), $userProduct->getAmount());
            }

            $this->userProductsModel->deleteByUserId($user->getId()); // очистка корзины

            return true;
        } else {
            return false;
        }
    }

    public function getAll(): array
    {
        $user = $this->authService->getCurrentUser();
        $userOrders = $this->orderModel->getAllByUserId($user->getId());

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

                $sum+=$orderProduct->getTotalSum();

                $newOrderProducts[] = $orderProduct;
            }
            $userOrder->setOrderProducts($newOrderProducts);

            $userOrder->setTotalSum($sum);
            $allUserOrders[] = $userOrder;

        }
        return $allUserOrders;
    }

}