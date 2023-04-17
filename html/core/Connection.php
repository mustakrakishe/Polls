<?php

namespace Core;

use Core\Contracts\ConnectionInterface;
use PDO;

class Connection implements ConnectionInterface
{
    protected ?PDO $dbh;

    public function __construct(string $driver, string $host, int $port, string $database, string $username, string $password)
    {
        $this->dbh = new PDO(
            $this->makeDsn($driver, $host, $port, $database),
            $username,
            $password
        );
    }

    public function __destruct()
    {
        $this->dbh = null;
    }

    protected static function makeDsn(string $driver, string $host, int $port, string $database) : string
    {
        return "$driver:host=$host;port=$port;dbname=$database";
    }

    public function insert(string $table, array $input)
    {
        $columns    = array_keys($input);
        $params     = array_map(fn ($column) => ":$column", $columns);

        $columnStr  = join(',', $columns);
        $paramStr   = join(',', $params);

        $stmt = $this->dbh->prepare("INSERT INTO $table ($columnStr) VALUES ($paramStr);");
        
        foreach ($params as $i => $param) {
            $stmt->bindParam($param, ${$columns[$i]});
        }

        extract($input);

        return $stmt->execute();
    }

    public function select(string $table, array $where = [], int $limit = null)
    {
        $sql = "SELECT * FROM $table";

        if ($where) {
            $whereStatementStrings = array_map(function ($statementParts) {
                return $statementParts[0] . '="' . $statementParts[1] . '"';
            }, $where);

            $sql .= ' WHERE ' . join(' AND ', $whereStatementStrings);
        }

        if (!is_null($limit)) {
            $sql .= " LIMIT $limit";
        }

        return $this->dbh->query($sql)->fetchAll();
    }

    public function getLastInsertId(string $table = null)
    {
        return $this->dbh->lastInsertId($table);
    }
}
