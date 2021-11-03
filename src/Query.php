<?php

namespace PhpBuilder;

class Query implements \Aigletter\Interfaces\Builder\QueryInterface
{
    protected $query;

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param mixed $query
     */
    public function setQuery($query): void
    {
        $this->query = $query;
    }

    public function __toString(): string
    {
        return $this->toSql();
    }
    public function toSql(): string
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