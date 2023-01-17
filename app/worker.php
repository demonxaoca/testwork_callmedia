<?php
declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';

use Dk\TestworkCallmedia\amqp\Connection;
use Dk\TestworkCallmedia\amqp\consumers\Consumer;
use PhpAmqpLib\Message\AMQPMessage;
use Dk\TestworkCallmedia\db\Db;
use Dk\TestworkCallmedia\amqp\producers\Producer;

$db = new Db('mysql', '3306', 'testwork', 'root', 'admin');
$connection = new Connection('rabbitmq', '5672', 'admin', 'admin');
$producer = new Producer($connection, 'urls', 'urls_exchange');
$consumer = new Consumer($connection, 'urls');
echo 'run consumer' . PHP_EOL;
$consumer->process(function (AMQPMessage $message) use ($db, $producer) {
    $url = $message->body;
    $ch = curl_init($url);
    $headers = [];
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_HEADERFUNCTION, function ($curl, $header) use (&$headers) {
        $len = strlen($header);
        $header = explode(':', $header, 2);
        if (count($header) < 2) // ignore invalid headers
            return $len;

        $headers[strtolower(trim($header[0]))] = trim($header[1]);

        return $len;
    });
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_exec($ch);
    $params = curl_getinfo($ch);
    $statusCode = $params['http_code'];

    if ($statusCode !== 200) {
        echo "repeat message [{$url}]" . PHP_EOL;
        $producer->publish($url, 15000);
        $message->ack();
        return;
    }

    $query = "INSERT INTO `urls` (`url`, `status_code`) VALUES (:url, :status_code)";
    $params = [
        ':url' => $url,
        ':status_code' => $statusCode
    ];
    $db->pdo->beginTransaction();
    try {
        $stmt = $db->pdo->prepare($query);
        $stmt->execute($params);
        $url_id = $db->pdo->lastInsertId();

        $paramsHeaders = array_fill(0, count($headers), '(?,?,?)');
        $queryHeaders = "INSERT INTO `urls_headers` (`url_id`, `key`, `value`) VALUES " . implode(',' , $paramsHeaders);
        $values = [];
        foreach($headers as $key => $value) {
            $values[] = $url_id;
            $values[] = $key;
            $values[] = $value;
        }

        $stmtHeaders = $db->pdo->prepare($queryHeaders);
        $stmtHeaders->execute($values);

        $db->pdo->commit();
    } catch (\Exception $e) {
        print_r($e);
        $db->pdo->rollBack();
    }
    print_r($params);
    print_r($headers);
    curl_close($ch);
    $message->ack();
    
});
