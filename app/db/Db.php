<?php
namespace Dk\TestworkCallmedia\db;

use PDO;

class Db {
    public $pdo;
    function __construct(string $host, string $port, $dbname, $uname, $pass) 
    {
        $this->pdo = new PDO("mysql:host={$host}:{$port};dbname={$dbname}",  $uname, $pass);
    }   
}