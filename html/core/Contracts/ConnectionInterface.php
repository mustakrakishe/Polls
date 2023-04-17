<?php

namespace Core\Contracts;

interface ConnectionInterface
{
    public function insert(string $table, array $input);
}