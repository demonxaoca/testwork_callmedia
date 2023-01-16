<?php

declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';

$numThreads = 5;
$threads = [];
for ($i = 1; $i <= 5; $i++) {
    $threads[] = popen('php ./app/worker.php', 'r');
}

echo  "count thread = ". count($threads) . PHP_EOL;

while(true) {
    foreach ($threads as $thread) {
        $read = fread($thread, 1024);
        echo $read;
    }
    sleep(10);
}




