<?php

namespace App\Services;

use App\Http\Requests\CreateOrderRequest;
use App\Jobs\CreateYouGileTaskJob;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\UserProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{
    private CartService $cartService;
    private YooKassaService $yooKassaService;
    public function __construct(CartService $cartService, YooKassaService $yooKassaService)
    {
        $this->cartService = $cartService;
        $this->yooKassaService = $yooKassaService;
    }

    /**
     * Создает заказ, отправляет в очередь создание task в yougile
     *  Создает платеж в Юкассе и выдает страницу с оплатой
     *
     * @param CreateOrderRequest $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|object
     * @throws \Throwable
     * @throws \YooKassa\Common\Exceptions\ApiConnectionException
     * @throws \YooKassa\Common\Exceptions\ApiException
     * @throws \YooKassa\Common\Exceptions\AuthorizeException
     * @throws \YooKassa\Common\Exceptions\BadApiRequestException
     * @throws \YooKassa\Common\Exceptions\ExtensionNotFoundException
     * @throws \YooKassa\Common\Exceptions\ForbiddenException
     * @throws \YooKassa\Common\Exceptions\InternalServerError
     * @throws \YooKassa\Common\Exceptions\NotFoundException
     * @throws \YooKassa\Common\Exceptions\ResponseProcessingException
     * @throws \YooKassa\Common\Exceptions\TooManyRequestsException
     * @throws \YooKassa\Common\Exceptions\UnauthorizedException
     */
    public function createOrder(CreateOrderRequest $request):string
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
            return $paymentUrl;


        } catch(\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }


}
