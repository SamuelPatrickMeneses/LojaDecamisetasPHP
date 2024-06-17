<?php

namespace Tests;

use Core\DB\DBConnectionHolder;
use Exception;
use PDO;
use PDOException;
use PHPUnit\Framework\TestCase;

class DBTestCase extends TestCase
{
    private static PDO $pdo;
    private static string $clear;
    private static string $reset;
    public static function setUpBeforeClass(): void
    {
        self::$pdo = DBConnectionHolder::getConnection();
        self::$clear = file_get_contents('/var/www/database/testCleaner.sql');
        self::$reset = file_get_contents('/var/www/database/dev.sql');
    }
    public function setUp(): void
    {
        try {

        
            self::$pdo->exec(self::$clear);
            self::$pdo->exec(self::$reset);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        } 
    }

    public function tearDown(): void
    {
        try {
            self::$pdo->exec(self::$clear);
            self::$pdo->exec(self::$reset);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        } 
    }

   # protected function getOutput(callable $callable): string
   # {
   #     ob_start();
   #     $callable();
   #     return ob_get_clean();
   # }
}
