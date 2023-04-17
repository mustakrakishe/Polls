<?php

namespace Core;

use PDO;

class Model
{
    protected string $dsn;
    protected string $username;
    protected string $password;
    protected string $table;

    public function __construct()
    {
        $this->dsn      = $this->makeDsn(
                            getenv('DB_DRIVER'),
                            getenv('DB_HOST'),
                            getenv('DB_PORT'),
                            getenv('DB_DATABASE')
                        );
        $this->username = getenv('DB_USERNAME');
        $this->password = getenv('DB_PASSWORD');
    }

    public function create(array $input)
    {
        $dbh = new PDO($this->dsn, $this->username, $this->password);

        $columns    = array_keys($input);
        $params     = array_map(fn ($column) => ":$column", $columns);

        $columnStr  = join(',', $columns);
        $paramStr   = join(',', $params);

        $stmt = $dbh->prepare("INSERT INTO $this->table ($columnStr) VALUES ($paramStr);");
        
        foreach ($params as $i => $param) {
            $stmt->bindParam($param, $columns[$i]);
        }

        extract($input);

        $success = $stmt->execute();

        $dbh = null;

        return $success;
    }

    protected function makeDsn(string $driver, string $host, int $port, string $database) : string
    {
        return "$driver:host=$host;port=$port;dbname=$database";
    }
}