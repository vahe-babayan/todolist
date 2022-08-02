<?php

namespace Core;

class DB
{
    static $db = null;

    public static function getInstance()
    {
        if (self::$db === null) {
            self::$db = new \mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        }

        return self::$db;
    }
}
