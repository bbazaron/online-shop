<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Services\CartService;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
use App\Models\UserProduct;
use Illuminate\Support\Facades\Auth;

class OrderController
{
    protected $cartService;
    public function __construct()
    {
        $this->cartService = new cartService();
    }
    public function getOrderForm()
    {
        $userProducts = $this->cartService->getUserProductsWithSum();
        $totalSum = $this->cartService->getTotalSum();
        return view('orderForm', ['userProducts' => $userProducts, 'totalSum' => $totalSum]);
    }

    public function createOrder(CreateOrderRequest $request)
    {
        $order = Order::query()->create([
            'user_id' => Auth::id(),
            'contact_name' => $request->get('contact_name'),
            'contact_phone' => $request->get('contact_phone'),
            'address' => $request->get('address'),
            'comment' => $request->get('comment'),
        ]);

        $userProducts = $this->cartService->getUserProductsWithSum();
            foreach ($userProducts as $userProduct) {
                OrderProduct::query()->create([
                    'order_id' => $order->id,
                    'product_id' => $userProduct->id,
                    'amount' => $userProduct->amount,
                ]);
            }

            UserProduct::query()->where('user_id',Auth::id())->delete();

            return response()->redirectTo('catalog');
    }

    public function getOrders()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $orders = $user->orders()->with('orderProducts.product')->get();
//        echo"<pre>";print_r($orders);
        return view('orders', ['orders' => $orders]);
    }
}
