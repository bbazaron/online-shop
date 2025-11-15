<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Jobs\DeleteYouGileTaskJob;
use App\Services\CartService;
use App\Services\DTO\CreateOrderDTO;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;

/**
 * Контроллер отвечающий за заказы
 */
class OrderController
{
    protected CartService $cartService;
    private OrderService $orderService;

    public function __construct(cartService $cartService, OrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     * Выдает страницу оформления заказа
     */
    public function getOrderForm()
    {
        $userProducts = $this->cartService->getUserProductsWithSum();
        $totalSum = $this->cartService->getTotalSum();
        return view('orderForm', ['userProducts' => $userProducts, 'totalSum' => $totalSum]);
    }

    /**
     * @param CreateOrderRequest $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|object
     * @throws \Throwable
     * Создает заказ, отправляет в очередь создание task в yougile
     * Создает платеж в Юкассе и выдает страницу с оплатой
     */
    public function createOrder(CreateOrderRequest $request)
    {
        $dto = CreateOrderDTO::fromRequest($request);
        $paymentUrl = $this->orderService->createOrder($dto);
        return redirect($paymentUrl);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     * Выдает страницу заказов пользователя
     */
    public function getOrders()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $orders = $user->orders()->with('orderProducts.product')->get();
        return view('orders', ['orders' => $orders]);
    }

    /**
     * @param string $taskId
     * @return void
     * Удаляет task с доски yougileУ
     */
    public function deleteTask(string $taskId)
    {
        DeleteYouGileTaskJob::dispatch($taskId);
    }
}
