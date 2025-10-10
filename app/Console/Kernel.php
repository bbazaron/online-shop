<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Зарегистрированные команды artisan.
     */
    protected $commands = [
        // \App\Console\Commands\YourCommand::class,
    ];

    /**
     * Планировщик задач.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:task-id-check-you-gile-command')
                ->everyMinute()
                ->sendOutputTo(storage_path('logs/scheduler.log'));;
    }

    /**
     * Регистрация команд.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
