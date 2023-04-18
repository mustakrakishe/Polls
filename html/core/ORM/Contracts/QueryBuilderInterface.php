<?php

namespace Core\ORM\Contracts;

interface QueryBuilderInterface
{
    public function table(string $table) : self;
    
    public function where(string $column, string $operator, $value) : self;

    public function select(array $columns = ['*']) : array;

    public function insert(array $attributes) : array;

    public function lastInsertId();

    public function newInstance() : self;
}