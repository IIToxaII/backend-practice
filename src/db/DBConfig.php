<?php
/**
 * Created by PhpStorm.
 * User: djtoryx
 * Date: 11.10.2018
 * Time: 21:39
 */

namespace App\db;


class DBConfig
{
    public $dns;
    public $username;
    public $password;

    public function __construct(array $config)
    {
        $this->dns = $config['dns'];
        $this->username = $config['username'];
        $this->password = $config['password'];
    }
}