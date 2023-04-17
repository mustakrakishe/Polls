<?php

namespace Core;

use Core\Contracts\ConnectionInterface;
use PDO;

class Connection implements ConnectionInterface
{
    protected PDO $dbh;

    public function __construct(string $driver, string $host, int $port, string $database, string $username, string $password)
    {
        $this->dbh = new PDO(
            $this->makeDsn($driver, $host, $port, $database),
            $username,
            $password
        );
    }

    protected static function makeDsn(string $driver, string $host, int $port, string $database) : string
    {
        return "$driver:host=$host;port=$port;dbname=$database";
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->dbh, $name], $arguments);
    }
}
