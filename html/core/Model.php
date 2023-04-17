<?php

namespace Core;

use Core\Contracts\ConnectionInterface;

class Model
{
    protected static ConnectionInterface $connection;
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
            $stmt->bindParam($param, ${$columns[$i]});
        }

        extract($input);

        $success = $stmt->execute();

        $dbh = null;

        return $success;
    }

    protected static function connection()
    {
        if (!isset(static::$connection)) {
            static::$connection = new Connection(
                getenv('DB_DRIVER'),
                getenv('DB_HOST'),
                getenv('DB_PORT'),
                getenv('DB_DATABASE'),
                getenv('DB_USERNAME'),
                getenv('DB_PASSWORD')
            );
        }
        
        return static::$connection;
    }
}