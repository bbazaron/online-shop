<?php

namespace App\Http\Services\Clients;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use YooKassa\Client;

class YooKassaClient
{
    private string $baseUrl;
    private string $apiKey;
    private string $shopId;

    public function __construct()
    {
        $this->baseUrl = config('services.yookassa.base_url');
        $this->apiKey = config('services.yookassa.api_key');
        $this->shopId = config('services.yookassa.shop_id');
    }

    public function createPayment(Order $order)
    {
        $paymentIdempotenceKey = uniqid('order_'.$order->id.'_', true); // уникальный ключ идемпотентности
        $client = new Client();
        $client->setAuth($this->shopId, $this->apiKey);

    }
}
