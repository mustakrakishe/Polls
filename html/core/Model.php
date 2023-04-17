<?php

namespace Core;

use Core\Contracts\ConnectionInterface;

class Model
{
    protected static ConnectionInterface $connection;
    protected static string $table;

    public static function create(array $input)
    {
        return static::connection()->insert(static::$table, $input);
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