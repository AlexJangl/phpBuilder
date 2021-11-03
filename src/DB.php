<?php

namespace PhpBuilder;

use Aigletter\Interfaces\Builder\QueryInterface;

class DB implements \Aigletter\Interfaces\Builder\DbInterface
{
    protected $mysql;
    public function __construct()
    {
        $this->mysql = \PhpBuilder\include\ConnectDB::getInstance()->connnection;
    }

    public function one(QueryInterface $query): object
    {
        if ($this->mysql->errno)
        {
            exit('CONNECT ERROR');
        }
        $result = $this->mysql->query($query);
        return $result->fetch_object('stdClass');
    }

    /**
     * @inheritDoc
     */
    public function all(QueryInterface $query): array
    {
        if ($this->mysql->errno)
        {
            exit('CONNECT ERROR');
        }
        $result = $this->mysql->query($query);

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}