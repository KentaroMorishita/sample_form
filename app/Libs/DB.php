<?php

namespace App\Libs;

use App\Libs\Config;

class DB
{

	public static $connection;

	public static function connect()
	{
		if (!self::$connection) {
			list($host, $user, $password, $dbname) = array_values(Config::get('DB'));
			self::$connection = new \PDO("mysql:host={$host};dbname={$dbname};", $user, $password);
		}
		return self::$connection;
	}

}
