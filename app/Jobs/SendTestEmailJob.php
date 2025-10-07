<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendTestEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $email;
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function handle(): void
    {
        Mail::raw('Это тестовое письмо через RabbitMQ очередь!', function ($message) {
            $message->to($this->email)
                ->subject('Тестовая рассылка');
        });
    }

    /**
     * Execute the job.
     */

//    public function handle(): void
//    {
//        Mail::to($this->email)->send(new TestEmail(
//            username: 'Иван',
//            bodyText: 'Это текст из очереди.',
//            ctaUrl: 'https://example.com',
//            fromName: 'Laravel App'
//        ));
//    }



}
