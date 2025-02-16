<?php
namespace App\Repositories\Impl;

use PDO;

class PDOClient extends PDO {

    private static self|null $instance = null;

    private function __construct() {
        $host = getenv('DB_HOST');
        $dbname = getenv('DB_NAME');
        $user = getenv('DB_USER');
        $pass = getenv('DB_PASS');

        $dns = "pgsql:host=$host;port=5432;dbname=$dbname";

        parent::__construct($dns, $user, $pass);
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new PDOClient();
        }

        return self::$instance;
    }

}
