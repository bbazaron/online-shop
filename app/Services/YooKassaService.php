<?php

namespace App\Services;
use App\Models\Order;
use Illuminate\Http\Request;
use YooKassa\Client;

/**
 * Сервис отвечает за Юкассу
 */
class YooKassaService
{
    private Client $client;
    private string $baseUrl;
    private string $apiKey;
    private string $shopId;
    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = config('services.yookassa.base_url');
        $this->apiKey = config('services.yookassa.api_key');
        $this->shopId = config('services.yookassa.shop_id');
    }

    /**
     * Создает платеж Юкассы и выдает url для оплаты
     *
     * @param Order $order
     * @return string
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
    public function createPayment(Order $order):string
    {
        $paymentIdempotenceKey = uniqid('order_'.$order->id.'_', true); // уникальный ключ идемпотентности
        $this->client->setAuth($this->shopId, $this->apiKey);
        $payment = $this->client->createPayment([
            'amount' => [
                'value' => $order->total_sum,
                'currency' => 'RUB',
            ],
            'capture' => true,
            'confirmation' => [
                'type' => 'redirect',
                'return_url' => route('catalog')
            ],
            'description' => "Оплата заказа №{$order->id}",
            'metadata' => [
                'order_id' => $order->id
            ],
        ], $paymentIdempotenceKey);
        \Log::info($payment->getConfirmation()->getConfirmationUrl());
        return ($payment->getConfirmation()->getConfirmationUrl());

    }


    /**
     * Обрабатывает вебхук Юкассы. Изменяет статус заказа при успешном платеже
     *
     * @param Request $request
     * @return void
     */
    public function handleWebhook(Request $request)
    {
        $data = $request->json()->all();
        \Log::info('YooKassa webhook received: ' . json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        if (isset($data['event']) && $data['event'] === 'payment.succeeded') {
            $payment = $data['object'];
            $orderId = $payment['metadata']['order_id'] ?? null;

            if ($orderId) {

                $order = Order::find($orderId);
                if ($order) {
                    $order->status = 'paid';
                    $order->save();
                }
            }
        }
    }


}
