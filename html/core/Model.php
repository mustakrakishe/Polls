<?php

namespace Core;

use Core\Contracts\ConnectionInterface;

class Model
{
    protected static ConnectionInterface $connection;
    protected static string $table;

    protected static array $where;
    protected static int $limit;

    public static function create(array $input)
    {
        static::connection()->insert(static::$table, $input);

        return static::connection()->getLastInsertId(static::$table);
    }

    /**
     * @param array $statements an array of [$field, $condition, $value] for each statement
     */
    public static function where(array $statements)
    {
        $model = new static;
        $model::$where = $statements;

        return $model;
    }

    public static function first()
    {
        static::$limit = 1;

        return static::connection()->select(static::$table, static::$where, static::$limit)[0] ?? null;
    }

    public static function table(string $table)
    {
        $model = new static;
        $model::$table = $table;

        return $model;
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