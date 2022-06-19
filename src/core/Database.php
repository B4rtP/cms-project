<?php
namespace Cms\core;

use PDO;

final class Database {

    private static $dbInstance = null;
    private static $dbConnection;

    public static function getInstance() {
        if (is_null(self::$dbInstance)) {
            self::$dbInstance = new Database();
        }
        return self::$dbInstance;
    }

    public function connect($dsn, $username, $password) {
        self::$dbConnection = new PDO($dsn, $username, $password);
    }

    public function getConnection() {
        return self::$dbConnection;
    }
}