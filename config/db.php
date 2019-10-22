<?php

/**
 ** Класс конфигурации базы данных
 */
class Database
{
    const HOST = "127.0.0.1";
    const DB   = "winestyle";
    const USER = "root";
    const PASS = "02_PHP_storM";

    public static function connectionToDB()
    {
        $user = self::USER;
        $pass = self::PASS;
        $host = self::HOST;
        $db   = self::DB;

        $connection = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        return $connection;
    }
}