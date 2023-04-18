<?php

namespace Core\Contracts;

interface ConnectionInterface
{
    public function executePreparedStatement(string $statement, array $parameters = []);

    public function lastInsertId();
}