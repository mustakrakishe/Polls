<?php

namespace Core\ORM;

use Core\ORM\Contracts\ModelInterface;
use Core\ORM\Contracts\QueryBuilderInterface;

class Model implements ModelInterface
{
    protected QueryBuilderInterface $queryBuilder;

    public function __construct(QueryBuilderInterface $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    public function get(string $table, array $where) : array
    {
        $builder = $this->queryBuilder
                        ->newInstance()
                        ->table($table);
        
        foreach ($where as $statement) {
            $builder->where(...$statement);
        }
        
        return $builder->select();
    }

    public function first(string $table, array $where) : array
    {
        return $this->get($table, $where)[0] ?? [];
    }

    public function create(string $table, array $attributes)
    {
        $this->queryBuilder
             ->newInstance()
             ->table($table)
             ->insert($attributes);

        return $this->queryBuilder
                    ->newInstance()
                    ->lastInsertId();
    }
}