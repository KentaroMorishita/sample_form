<?php

namespace App\Libs;

/**
 * Class DB
 * @package App\Libs
 */
class DB
{


    /**
     *
     */
    public static function connect()
    {
        list($host, $user, $password, $dbname) = array_values(Config::get('DB'));
        \ORM::configure("mysql:host={$host};dbname={$dbname};charset=utf8;");
        \ORM::configure('username', $user);
        \ORM::configure('password', $password);
    }

}
