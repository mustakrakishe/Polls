<?php

namespace Core\ORM;

use Core\Contracts\ConnectionInterface;
use Core\ORM\Concerns\PreparesStatement;
use Core\ORM\Contracts\QueryBuilderInterface;

class QueryBuilder implements QueryBuilderInterface
{
    use PreparesStatement;

    protected ConnectionInterface $connection;
    protected string $table;
    protected array $where = [];

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    public function newInstance() : self
    {
        return new static($this->connection);
    }

    public function table(string $table) : self
    {
        $this->table = $table;

        return $this;
    }

    public function where(string $column, string $operator, $value) : self
    {
        $this->where[] = compact('column', 'operator', 'value');

        return $this;
    }

    public function select(array $columns = ['*']) : array
    {
        return $this->connection
                    ->executePreparedStatement(
                        $this->prepareSelectStatement($this->table, $columns, $this->where)
                    );
    }

    public function insert(array $attributes) : array
    {
        return $this->connection
                    ->executePreparedStatement(
                        $this->prepareInsertStatement($this->table, $attributes)
                    );
    }

    public function lastInsertId()
    {
        return $this->connection->lastInsertId();
    }
}