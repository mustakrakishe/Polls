<?php

namespace Core\Validation\Concerns;

use Core\Model;

trait Rules
{
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
        $record = Model::table($table)->where([
            [$column, $value],
        ])->first();

        return is_null($record);
    }
}