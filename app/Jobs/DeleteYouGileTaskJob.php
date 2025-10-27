<?php

namespace App\Jobs;

use App\Http\Services\Clients\YouGileClient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

/**
 * Удаляет task с доски Yougile
 */
class DeleteYouGileTaskJob implements ShouldQueue
{
    use Queueable;

    private string $taskId;
    private YouGileClient $client;
    public function __construct(string $taskId)
    {
        $this->taskId = $taskId;
        $this->client = new YouGileClient();
    }

    public function handle(): void
    {
        $success = $this->client->deleteTask($this->taskId);

        if (!$success) {
            Log::warning("YouGile: не удалось удалить задачу ");
        }
    }
}
