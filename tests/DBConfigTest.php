<?php

use PHPUnit\Framework\TestCase;
use App\db\DBConfig;

class DBConfigTest extends TestCase
{
    public function testConfig()
    {
        $config = require_once __DIR__. "/../config/config.php";
        $db = $config['db'];
        $dbConfig = new DBConfig($db);
        $this->assertEquals($dbConfig->dns, $db['dns']);
        $this->assertEquals($dbConfig->password, $db['password']);
        $this->assertEquals($dbConfig->username, $db['username']);
    }
}
?>