<?php
require __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('rabbitmq', 5672, 'user', 'password');
$channel = $connection->channel();

$channel->queue_declare('hello', false, false, false, false);

$msg = new AMQPMessage('Hello RabbitMQ!');
$channel->basic_publish($msg, '', 'hello');

echo " [x] Sent 'Hello RabbitMQ!'\n";

$channel->close();
$connection->close();
