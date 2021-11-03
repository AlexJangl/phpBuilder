<?php

namespace PhpBuilder\include;

use mysqli;

class ConnectDB
{
    private static $instance = null;
    private $connection;

    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $name = 'test';

    private function __construct()
    {
        $this->connnection = new mysqli($this->host, $this->user, $this->pass, $this->name);
    }

    public static function getInstance()
    {
        if(!self::$instance)
        {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}