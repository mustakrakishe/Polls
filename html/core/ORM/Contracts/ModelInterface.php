<?php

namespace Core\ORM\Contracts;

interface ModelInterface
{
    public function create(string $table, array $attributes);

    public function get(string $table, array $where) : array;

    public function first(string $table, array $where) : array;
}