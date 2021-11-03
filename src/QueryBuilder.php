<?php

namespace PhpBuilder;

use Aigletter\Interfaces\Builder\BuilderInterface;
use Aigletter\Interfaces\Builder\QueryInterface;

class QueryBuilder implements \Aigletter\Interfaces\Builder\QueryBuilderInterface
{
    protected $queryObj;

    public function __construct()
    {
        $this->queryObj = new Query();
    }

    protected function reset(): void
    {
        $this->queryObj->setQuery(new \stdClass());
    }

    public function select($columns): \Aigletter\Interfaces\Builder\BuilderInterface
    {
        $table = $this->queryObj->getQuery()->base;
        $this->queryObj->getQuery()->base = "SELECT " . implode(", ", $columns) . " FROM " . $table;
        $this->queryObj->getQuery()->type = 'select';
        return $this;
    }


    public function where($conditions): \Aigletter\Interfaces\Builder\BuilderInterface
    {
        if (!in_array($this->queryObj->getQuery()->type, ['select', 'update', 'delete'])) {
            throw new \Exception("WHERE can only be added to SELECT, UPDATE OR DELETE");
        }
        foreach ($conditions as $key => $value){
            $this->queryObj->getQuery()->where = " WHERE $key = '$value'";
        }
        return $this;
    }

    public function table($table): \Aigletter\Interfaces\Builder\BuilderInterface
    {
        $this->reset();
        $this->queryObj->getQuery()->base = $table;
        return $this;
    }


    public function limit($limit): \Aigletter\Interfaces\Builder\BuilderInterface
    {
        if (!in_array($this->queryObj->getQuery()->type, ['select'])) {
            throw new \Exception("LIMIT can only be added to SELECT");
        }
        $this->queryObj->getQuery()->limit = " LIMIT " . $limit;

        return $this;
    }


    public function offset($offset): \Aigletter\Interfaces\Builder\BuilderInterface
    {
        if (!in_array($this->queryObj->getQuery()->type, ['select'])) {
            throw new \Exception("OFFSET can only be added to SELECT");
        }
        $this->queryObj->getQuery()->offset = " OFFSET " . $offset;

        return $this;
    }


    public function order($order): \Aigletter\Interfaces\Builder\BuilderInterface
    {
        if (!in_array($this->queryObj->getQuery()->type, ['select', 'update', 'delete'])) {
            throw new \Exception("WHERE can only be added to SELECT, UPDATE OR DELETE");
        }
        foreach ($order as $key => $value){
            $this->queryObj->getQuery()->order = " ORDER BY $key $value";
        }
        return $this;
    }
    public function build(): QueryInterface
    {
        return $this->queryObj;
    }
}