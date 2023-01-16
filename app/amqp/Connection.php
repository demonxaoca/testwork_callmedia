<?php
namespace Dk\TestworkCallmedia\amqp;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

class Connection {
    public $amqp;
    public $channel;
    function __construct($host, $port, $user, $pass) {
        $this->amqp = new AMQPStreamConnection($host, $port, $user, $pass);
        $this->channel = $this->amqp->channel();
    }

    function close()
    {
        $this->channel->close();
        $this->amqp->close();
    }
}