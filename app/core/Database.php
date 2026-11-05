<?php

class Database{
    private static $pdo = null;

    public static function getConnection(){
        if(self::$pdo == null){
            self::$pdo = new PDO('mysql:host=localhost;dbname=blogphpjs', 'root', 'rootroot',
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
            );
        }
        return self::$pdo;
    }
}