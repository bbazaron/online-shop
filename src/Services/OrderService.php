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
    private AuthInterface $authService;
    private CartService $cartService;

    public function __construct()
    {
        $this->authService = new AuthSessionService();
        $this->cartService = new CartService();
    }
    public function createOrder(OrderCreateDTO $dto):bool
    {
        $sum = $this->cartService->getSum(); // Проверка заказа на минимальную сумму
        if ($sum < 1000) {
            throw new \Exception('Минимальная сумма для оформления заказа - 1000 руб');
        }


        $user = $this->authService->getCurrentUser();

        $orderId = Order::create(
                                            $dto->getName(),
                                            $dto->getPhone(),
                                            $dto->getAddress(),
                                            $dto->getComment(),
                                            $user->getId()
                                            );                          // вводим данные заказа в таблицу


        $userProducts = UserProducts::getAllByUserId($user->getId()); // достаем все продукты из корзины


        if (isset($userProducts)) {

            foreach ($userProducts as $userProduct) { // вносим данные каждого товара из корзины в order_products
                OrderProducts::create($orderId, $userProduct->getProductId(), $userProduct->getAmount());
            }

            UserProducts::deleteByUserId($user->getId()); // очистка корзины

            return true;
        } else {
            return false;
        }
    }

    public function getAll(): array
    {
        $user = $this->authService->getCurrentUser();
        $userOrders = Order::getAllByUserId($user->getId());

        $allUserOrders = [];
        $sum=0;

        foreach ($userOrders as $userOrder) {

            $orderProducts = OrderProducts::getAllByOrderId($userOrder->getId());

            $newOrderProducts = [];
            $sum=0;
            foreach ($orderProducts as $orderProduct) {
                $product = Product::getById($orderProduct->getProductId());

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