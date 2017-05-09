<?php

namespace App\Libs;

class Csrf
{

	const ALGO = 'sha256';

	public static function getToken()
	{
		return hash(self::ALGO, session_id());
	}

	public static function checkToken($token)
	{
		$valid = self::getToken() === $token;
		if (!$valid) {
			throw new \RuntimeException('CSRF token is invalid', 400);
		} else {
			session_regenerate_id();
		}
		return $valid;
	}

}
