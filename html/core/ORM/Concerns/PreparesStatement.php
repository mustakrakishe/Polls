<?php

namespace Core\ORM\Concerns;

trait PreparesStatement
{
    protected function prepareSelectStatement(string $table, array $columns, array $where) : string
    {
        $columns    = $this->columns($columns);

        return "SELECT $columns FROM $table" . $this->prepareWhereString($where) . ';';
    }

    protected function columns(array $columns) : string
    {
        if ($columns === []) {
            return '*';
        }

        return join(', ', $columns);
    }

    protected function prepareWhereString(array $where) : string
    {
        if ($where === []) {
            return '';
        }

        $strings = array_map(function ($statementParts) {
            extract($statementParts);

            $quotedValue = $this->quote($value);
            
            return "$column $operator $quotedValue";
        }, $where);

        return ' WHERE ' . join(' AND ', $strings);
    }

    protected function prepareInsertStatement(string $table, array $attributes)
    {
        $columns    = $this->columns(array_keys($attributes));
        $values     = $this->values($attributes);

        return "INSERT $table ($columns) VALUES ($values);";
    }

    protected function values(array $values) : string
    {
        if ($values === []) {
            return '';
        }

        $quoted = array_map([$this, 'quote'], $values);

        return join(', ', $quoted);
    }

    protected function quote(string $string) : string
    {
        return '"' . $string . '"';
    }
}