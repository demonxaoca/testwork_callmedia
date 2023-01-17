<?php
namespace Dk\TestworkCallmedia\amqp\producers;

use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;
use Dk\TestworkCallmedia\amqp\Connection;
use PhpAmqpLib\Wire\AMQPTable;

class Producer {
    private $channel;
    private $exchange;
    function __construct(Connection $conn, string $queue, string $exchange) {
        $conn->channel->exchange_declare($exchange, 'x-delayed-message', false, true, false, false, false, new AMQPTable(array(
            'x-delayed-type' => AMQPExchangeType::FANOUT
        )));
        $conn->channel->queue_declare($queue, false, false, false, false, false, new AMQPTable(array(
            'x-dead-letter-exchange' => 'delayed'
        )));
        $conn->channel->queue_bind($queue, $exchange);
        $this->channel = $conn->channel;
        $this->exchange = $exchange;
    }

    function publish(string $messageBody = '', int $delay = 30_000, $isRepeat = false) {
        $headers = new AMQPTable(array('x-delay' => $delay));
        $message = new AMQPMessage(json_encode(['url' => $messageBody, 'isRepeat' => $isRepeat]), array('content_type' => 'text/plain', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
        $message->set('application_headers', $headers);
        $this->channel->basic_publish($message, $this->exchange);
        echo "message send" . PHP_EOL;
    }
}
