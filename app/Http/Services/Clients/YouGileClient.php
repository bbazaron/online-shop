<?php

namespace App\Http\Services\Clients;

use App\Http\Services\Clients\DTO\YouGileClientCreateTaskDTO;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class YouGileClient
{
    private string $baseUrl;
    private string $apiKey;
    private string $columnId;

    public function __construct()
    {
        $this->baseUrl = config('services.yougile.base_url');
        $this->apiKey = config('services.yougile.api_key');
        $this->columnId = config('services.yougile.column_id');
    }
    public function createTask(YouGileClientCreateTaskDTO $dto):bool
    {
        $maxAttempts = 3;
        $attempt = 0;

        do {
            $attempt++;

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',

            ])->post($this->baseUrl . '/api-v2/tasks', [
                'title' => 'Заказ #' . $dto->getOrderId(),
                'columnId' => $this->columnId,
                'description' =>$dto->getDescription(),
            ]);

            if ($response->successful()) {
                return true;
            }

        } while($attempt < $maxAttempts);

        {
            Log::error('Yougile API error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return false;
        }
    }


    public function deleteTask(string $taskId):bool
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',

        ])->put($this->baseUrl . '/api-v2/tasks/' . $taskId, [
            'columnId' => '-',
        ]);

        if (!$response->successful()) {
            Log::error('Yougile API error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return false;
        }
        return true;
    }
}
