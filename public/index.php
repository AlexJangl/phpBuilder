<?php

include __DIR__.'\..\vendor\autoload.php';

function clientCode(\Aigletter\Interfaces\Builder\SqlBuilderInterface $queryBuilder)
{
    $query = $queryBuilder
        ->table("users")
        ->select( ["first_name", "age"])
        ->where(["status" => "active"])
        ->order(["id" => "ASK"])
        ->limit(20)
        ->offset(40)
        ->build();
    return $query;
}
function clientCodeTaskTwo(\Aigletter\Interfaces\Builder\QueryBuilderInterface $queryBuilder)
{
    $query = $queryBuilder
        ->table("users")
        ->select( ["first_name", "age"])
        ->where(["status" => "active"])
        ->order(["id" => "ASK"])
        ->limit(20)
        ->offset(40)
        ->build();
    return $query;
}

function clientCodeTaskThree(\Aigletter\Interfaces\Builder\QueryBuilderInterface $queryBuilder)
{
    $query = $queryBuilder
        ->table("users")
        ->select(["first_name", "age"])
        ->where(["id" => 23])
        ->build();
    return $query;
}

echo "Testing MySQL query builder task one:".PHP_EOL;
$query = clientCode(new \PhpBuilder\SqlBuilder());

echo $query;
echo "\n\n";

echo "Testing MySQL query builder task two:".PHP_EOL;
$queryTwo = clientCodeTaskTwo(new \PhpBuilder\QueryBuilder());
echo ((string)$queryTwo).PHP_EOL;

echo "Testing MySQL query builder task two:".PHP_EOL;
$queryThree = clientCodeTaskThree(new \PhpBuilder\QueryBuilder());

$db = new \PhpBuilder\DB();
print_r($db->one($queryThree));
print_r($db->all($queryThree));