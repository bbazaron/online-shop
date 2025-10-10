<?php

namespace App\Jobs;

use App\Http\Services\Clients\DTO\YouGileClientCreateTaskDTO;
use App\Http\Services\Clients\YouGileClient;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CreateYouGileTaskJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Order $order;
    private YouGileClient $youGileClient;
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->youGileClient = new YouGileClient();
    }

    public function handle(): void
    {
        $orderId = $this->order->id;
        $description = "
                            - Имя: {$this->order->contact_name}<br>
                            - Телефон: {$this->order->contact_phone}<br>
                            - Адрес: {$this->order->address}<br>
                            - Комментарий: {$this->order->comment}";

        $dto = new YouGileClientCreateTaskDTO($description, $orderId );

        $taskId = $this->youGileClient->createTask($dto);


        if ($taskId===false) {
            Log::warning("YouGile: не удалось создать задачу для заказа #{$this->order->id}");
        } else{
                Order::query()->where('id',$orderId)->update(['yougile_task_id' => $taskId]);
        }


    }
}
