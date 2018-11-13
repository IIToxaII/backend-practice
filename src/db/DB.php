<?php

namespace App\db;

use PDO;


class DB
{
    public $connection;

    public function __construct(DBConfig $config)
    {
        $this->connection = new PDO($config->dns, $config->username, $config->password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }
}