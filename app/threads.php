<?php

declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';

$numThreads = 5;
$threads = [];
for ($i = 0; $i <= $numThreads; $i++) {
    $threads[] = popen('php ./app/worker.php', 'r');
}



