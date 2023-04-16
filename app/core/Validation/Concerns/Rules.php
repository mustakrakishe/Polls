<?php

namespace Core\Validation\Concerns;

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
}