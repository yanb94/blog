<?php

namespace Framework;

class PDOFactory
{
    public static function getMysqlConnexion(string $host, string $db, string $user, string $password)
    {
        $db = new \PDO('mysql:host='.$host.';dbname='.$db, $user, $password);
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $db;
    }
}
