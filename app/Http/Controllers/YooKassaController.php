<?php

namespace App\Http\Controllers;

use App\Http\Services\YooKassaService;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

//use Illuminate\Support\Facades\Request;

class YooKassaController
{
    public function handle(Request $request)
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

        return response()->json(['status' => 'ok']);
    }

}
