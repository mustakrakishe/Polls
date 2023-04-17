<?php

namespace Core;

use PDO;

class Model
{
    protected static PDO $connection;
    protected static string $table;

    public static function create(array $input)
    {
        $dbh = static::connection();

        $table = static::$table;

        $columns    = array_keys($input);
        $params     = array_map(fn ($column) => ":$column", $columns);

        $columnStr  = join(',', $columns);
        $paramStr   = join(',', $params);

        $stmt = $dbh->prepare("INSERT INTO $table ($columnStr) VALUES ($paramStr);");
        
        foreach ($params as $i => $param) {
            $stmt->bindParam($param, $columns[$i]);
        }

        extract($input);

        $success = $stmt->execute();

        $dbh = null;

        return $success;
    }

    protected static function connection()
    {
        if (!isset(static::$connection)) {
            $dsn        = static::makeDsn(
                            getenv('DB_DRIVER'),
                            getenv('DB_HOST'),
                            getenv('DB_PORT'),
                            getenv('DB_DATABASE')
                        );
            $username   = getenv('DB_USERNAME');
            $password   = getenv('DB_PASSWORD');

            static::$connection =  new PDO($dsn, $username, $password);
        }
        
        return static::$connection;
    }

    protected static function makeDsn(string $driver, string $host, int $port, string $database) : string
    {
        return "$driver:host=$host;port=$port;dbname=$database";
    }
}