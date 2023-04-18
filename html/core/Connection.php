<?php

namespace Core;

use Core\Contracts\ConnectionInterface;
use PDO;
use PDOStatement;

class Connection implements ConnectionInterface
{
    protected ?PDO $pdo;
    protected PDOStatement $statement;

    public function __construct(string $driver, string $host, int $port, string $database, string $username, string $password)
    {
        $this->pdo = new PDO(
            "$driver:host=$host;port=$port;dbname=$database",
            $username,
            $password
        );
    }

    public function __destruct()
    {
        $this->pdo = null;
    }

    public function executePreparedStatement(string $statement, array $parameters = [])
    {
        $this->statement = $this->pdo->prepare($statement);

        foreach (array_keys($parameters) as $column) {
            $this->statement->bindParam(":$column", ${$column});
        }

        extract($parameters);

        $this->statement->execute();

        return $this->statement->fetchAll();
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}
