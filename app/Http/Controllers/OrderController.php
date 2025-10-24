<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Services\CartService;
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


class OrderController
{
    protected CartService $cartService;
    private YooKassaService $yooKassaService;

    public function __construct()
    {
        $this->cartService = new cartService();
        $this->yooKassaService = new YooKassaService();

    }
    public function getOrderForm()
    {
        $userProducts = $this->cartService->getUserProductsWithSum();
        $totalSum = $this->cartService->getTotalSum();
        return view('orderForm', ['userProducts' => $userProducts, 'totalSum' => $totalSum]);
    }

    public function createOrder(CreateOrderRequest $request)
    {
        $userProducts = $this->cartService->getUserProductsWithSum();
        $totalSum = $this->cartService->getTotalSum();
        DB::beginTransaction();
        try {
            $order = Order::query()->create([
                'user_id' => Auth::id(),
                'contact_name' => $request->get('contact_name'),
                'contact_phone' => $request->get('contact_phone'),
                'address' => $request->get('address'),
                'comment' => $request->get('comment'),
                'total_sum' => $totalSum,
            ]);

            foreach ($userProducts as $userProduct) {
                OrderProduct::query()->create([
                    'order_id' => $order->id,
                    'product_id' => $userProduct->id,
                    'amount' => $userProduct->amount,
                ]);
            }

            UserProduct::query()->where('user_id',Auth::id())->delete();
            DB::commit();

            CreateYouGileTaskJob::dispatch($order);

            $paymentUrl = $this->yooKassaService->createPayment($order);
            return redirect($paymentUrl);


        } catch(\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }

    }

    public function getOrders()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $orders = $user->orders()->with('orderProducts.product')->get();
//        echo"<pre>";print_r($orders);
        return view('orders', ['orders' => $orders]);
    }

    public function deleteTask(string $taskId)
    {
        DeleteYouGileTaskJob::dispatch($taskId);
    }
}
