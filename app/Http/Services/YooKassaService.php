<?php

namespace App\Http\Services;
use App\Models\Order;
use YooKassa\Client;


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

    public function successPayment(Order $order)
    {

    }
}
