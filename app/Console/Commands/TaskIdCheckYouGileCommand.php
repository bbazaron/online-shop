<?php

namespace App\Console\Commands;

use App\Jobs\CreateYouGileTaskJob;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TaskIdCheckYouGileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:task-id-check-you-gile-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    public function handle()
    {
        $orders = Order::query()->where('yougile_task_id',null)->get();
        foreach ($orders as $order) {
            CreateYouGileTaskJob::dispatch($order);
        }

        Log::info('TaskIdCheckYouGile сработала!');
        $this->info('Команда выполнена!');
    }
}
