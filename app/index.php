<?php
declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';

use Dk\TestworkCallmedia\amqp\Connection;
use Dk\TestworkCallmedia\amqp\producers\Producer;
use Dk\TestworkCallmedia\amqp\consumers\Consumer;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new Connection('rabbitmq', '5672', 'admin', 'admin');
//$connection = new Connection('localhost', '5672', 'admin', 'admin');
$producer = new Producer($connection, 'urls', 'urls_exchange');
[$file, $url] = $argv;
$producer->publish($url);
