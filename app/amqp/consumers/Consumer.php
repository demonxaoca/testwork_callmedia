<?php
namespace Dk\TestworkCallmedia\amqp\consumers;

use Closure;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;
use Dk\TestworkCallmedia\amqp\Connection;

class Consumer {
    private $channel;
    private $queue;
    function __construct(Connection $conn, string $queue) {
        $this->channel = $conn->channel;
        $this->queue = $queue;
    }
    
    function process(Closure $cb) {
        $this->channel->basic_consume($this->queue, '', false, false, false, false, $cb);
        $this->channel->consume();

    }


}