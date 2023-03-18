<?php

namespace App\Database;
use PDO;

class Connection {


    public static function pdo() {

        $options = [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        return new PDO(DB_DSN, DB_USER, DB_PASS, $options);

    }


}