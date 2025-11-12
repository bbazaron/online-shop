<?php

namespace App\Console\Commands;

use App\Mail\Testmail;
use App\Models\User;
use App\Services\RabbitmqService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SignUpNotifyCommand extends Command
{
    private RabbitmqService $rabbitmqService;
    public function __construct(RabbitmqService $rabbitmqService)
    {
        parent::__construct();
        $this->rabbitmqService = $rabbitmqService;
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sign-up-notify-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $callback = function($msg) {
            $data = json_decode($msg->body, true);

            $user=User::query()->find($data['user_id']);
            if ($user) {
                $email=$user->email;
                Mail::to($email)->send(new TestMail($user->username));
            }
        };

        $this->rabbitmqService->consume('sign-up_email', $callback);
    }

}
