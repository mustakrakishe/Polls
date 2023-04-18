<?php

namespace Core\Validation\Concerns;

use Core\ORM\Contracts\ModelInterface;

trait Rules
{
    protected ModelInterface $model;

    protected function required($value)
    {
        return !empty($value);
    }

    protected function email(string $value)
    {
        return (bool) filter_var($value, FILTER_VALIDATE_EMAIL);
    }
    
    protected function min(string $value, int $limit)
    {
        return strlen($value) >= $limit;
    }

    protected function unique(string $value, string $table, string $column)
    {
        $record = $this->model
                       ->first($table, [
                           [$column, '=', $value]
                       ]);

        return $record === [];
    }
}