<?php

namespace Core\DB;

use PDO;
use PDOException;

class DBConnectionHolder
{
    private static $connection;

    public static function getConnection()
    {
        if (!isset($connection)) {
            try {
                $host     = $_ENV['DB_HOST'];
                $dbname   = $_ENV['DB_NAME'];
                $user     = $_ENV['DB_USER'];
                $port     = $_ENV['DB_PORT'];
                $password = $_ENV['DB_PASSWORD'];
                self::$connection =  new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $password);
            } catch (PDOException) {
                echo 'connection error';
            }
        }
        return self::$connection;
    }
}
