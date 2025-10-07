<?php

namespace App\Http\Services;

use App\Mail\Testmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitmqService
{
    private AMQPStreamConnection $connection;
    public function __construct()
    {
        $this->connection = new AMQPStreamConnection('rabbitmq', 5672, 'user', 'password');

    }
    public function produce(array $data, string $queueName)
    {
        $channel = $this->connection->channel();

        $channel->queue_declare($queueName, false, false, false, false);

        $data = json_encode($data);         // потому что

        $msg = new AMQPMessage($data);      // аргумент принимает только string

        $channel->basic_publish($msg, '', $queueName);
    }

    public function consume(string $queueName, callable $callback)
    {
        $channel = $this->connection->channel();

        $channel->queue_declare($queueName, false, false, false, false);

        $channel->basic_consume($queueName, '', false, true, false, false, $callback);

        try {
            $channel->consume();
        } catch (\Throwable $exception) {
            echo $exception->getMessage();
        }
    }
}
