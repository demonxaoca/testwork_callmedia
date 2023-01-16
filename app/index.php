<?php
declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';

use Dk\TestworkCallmedia\amqp\Connection;
use Dk\TestworkCallmedia\amqp\producers\Producer;
use Dk\TestworkCallmedia\amqp\consumers\Consumer;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new Connection('localhost', '5672', 'admin', 'admin');
$producer = new Producer($connection, 'urls', 'urls_exchange');
$producer->publish('https://webhook.site/71f19308-9995-4e7b-bb0f-ee2ce5b3554a');
// $consumer = new Consumer($connection, 'urls');
// $consumer->process(function (AMQPMessage $message) {

//     //$message->ack();
//     print_r($message->body);
// });
