<?php

namespace PhpBuilder;

use Aigletter\Interfaces\Builder\BuilderInterface;

class SqlBuilder implements \Aigletter\Interfaces\Builder\SqlBuilderInterface
{

    protected $query;

    protected function reset(): void
    {
        $this->query = new \stdClass();
    }

    public function select($columns): \Aigletter\Interfaces\Builder\BuilderInterface
    {
        $table = $this->query->base;
        $this->query->base = "SELECT " . implode(", ", $columns) . " FROM " . $table;
        $this->query->type = 'select';
        return $this;
    }


    public function where($conditions): \Aigletter\Interfaces\Builder\BuilderInterface
    {
        if (!in_array($this->query->type, ['select', 'update', 'delete'])) {
            throw new \Exception("WHERE can only be added to SELECT, UPDATE OR DELETE");
        }
        foreach ($conditions as $key => $value){
            $this->query->where = " WHERE $key = '$value'";
        }
        return $this;
    }

    public function table($table): \Aigletter\Interfaces\Builder\BuilderInterface
    {
        $this->reset();
        $this->query->base = $table;
        return $this;
    }


    public function limit($limit): \Aigletter\Interfaces\Builder\BuilderInterface
    {
        if (!in_array($this->query->type, ['select'])) {
            throw new \Exception("LIMIT can only be added to SELECT");
        }
        $this->query->limit = " LIMIT " . $limit;

        return $this;
    }


    public function offset($offset): \Aigletter\Interfaces\Builder\BuilderInterface
    {
        if (!in_array($this->query->type, ['select'])) {
            throw new \Exception("OFFSET can only be added to SELECT");
        }
        $this->query->offset = " OFFSET " . $offset;

        return $this;
    }


    public function order($order): \Aigletter\Interfaces\Builder\BuilderInterface
    {
        if (!in_array($this->query->type, ['select', 'update', 'delete'])) {
            throw new \Exception("WHERE can only be added to SELECT, UPDATE OR DELETE");
        }
        foreach ($order as $key => $value){
            $this->query->order = " ORDER BY $key $value";
        }
        return $this;
    }

    public function build(): string
    {
        $query = $this->query;
        $sql = $query->base;
        if (!empty($query->where)) {
            $sql .= $query->where;
        }
        if (!empty($query->order)) {
            $sql .= $query->order;
        }
        if (isset($query->limit)) {
            $sql .= $query->limit;
        }
        if (isset($query->offset)) {
            $sql .= $query->offset;
        }
        $sql .= ";";
        return $sql;
    }
}