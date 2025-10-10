<?php

namespace App\Jobs;

use App\Http\Services\Clients\YouGileClient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class DeleteYouGileTaskJob implements ShouldQueue
{
    use Queueable;

    private string $taskId;
    public function __construct(string $taskId)
    {
        $this->taskId = $taskId;
    }

    public function handle(): void
    {
        $client = new YouGileClient();

        $success = $client->deleteTask($this->taskId);

        if (!$success) {
            Log::warning("YouGile: не удалось удалить задачу ");
        }
    }
}
