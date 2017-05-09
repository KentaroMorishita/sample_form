<?php

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

define('DS', DIRECTORY_SEPARATOR);

define('APP_ENV', 'development');

define('ROOT_PATH', realpath(__DIR__ . DS . '..' . DS));
define('APP_PATH', realpath(__DIR__ . DS));
define('CONTROLLER_PATH', realpath(APP_PATH . DS . 'Controllers'));
define('MODEL_PATH', realpath(APP_PATH . DS . 'Models'));
define('VIEW_PATH', realpath(APP_PATH . DS . 'Views'));

try {
	list($controller, $action) = explode(DS, filter_input(INPUT_GET, 'p'));

	$controller = "\\App\\Controllers\\" . $controller . 'Controller';
	$controller_instance = new $controller();
	$controller_instance->$action();
} catch (Throwable $e) {
	if (APP_ENV === 'development') {
		print("<pre>{$e}</pre>");
	}
	exit;
}

