<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Services\CartService;
use App\Http\Services\OrderService;
use App\Http\Services\YooKassaService;
use App\Jobs\CreateYouGileTaskJob;
use App\Jobs\DeleteYouGileTaskJob;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
use App\Models\UserProduct;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        $paymentUrl = $this->orderService->createOrder($request);
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
