<?php

namespace Core\Contracts;

interface ConnectionInterface
{
    public function insert(string $table, array $input);

    public function getLastInsertId(string $table = null);

    public function select(string $table, array $where = [], int $limit = null);
}