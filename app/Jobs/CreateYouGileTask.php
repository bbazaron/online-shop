<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CreateYouGileTask implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Order $order;
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function handle(): void
    {
        $token = 'rHKssJmK3aYTfF38o6dxIX-YQknhBjs4dkii2fP38aC7dW4ibuUoKWZuc2glxzhK';
        $columnId = 'bada0a7d-13bb-4a1a-9498-5780f2f76fda';
        $description = "
                            - Имя: {$this->order->contact_name}<br>
                            - Телефон: {$this->order->contact_phone}<br>
                            - Адрес: {$this->order->address}<br>
                            - Комментарий: {$this->order->comment}";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',

        ])->post("https://ru.yougile.com/api-v2/tasks", [
            'title' => 'Заказ #' . $this->order->id,
            'columnId' => $columnId,
            'description' => $description,
        ]);

        if (!$response->successful()) {
            Log::error('Yougile API error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        }
    }
}
