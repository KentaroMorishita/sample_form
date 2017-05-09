<?php

namespace App\Controllers;

use Twig_Loader_Filesystem;
use Twig_Environment;

class Controller
{

	const REQUEST_POST = 'POST';
	const REQUEST_GET = 'GET';

	protected $view;

	/**
	 *
	 */
	public function __construct()
	{
		$this->method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

		$loader = new Twig_Loader_Filesystem(VIEW_PATH);
		$this->view = new Twig_Environment($loader, [
			'cache' => ROOT_PATH . '/cache/',
			'debug' => true
		]);

		\App\Libs\DB::connect();
	}

	/**
	 *
	 * @param type $template_path
	 * @param type $data
	 * @return type
	 */
	protected function view($template_path, $data = [])
	{
		$template = $this->view->loadTemplate($template_path);
		return $template->display($data);
	}

	/**
	 *
	 * @return type
	 */
	protected function post()
	{
		return filter_input_array(INPUT_POST);
	}

	/**
	 *
	 * @return type
	 */
	protected function get()
	{
		$get = filter_input_array(INPUT_GET);
		unset($get['p']);
		return $get;
	}

	/**
	 *
	 * @param type $controller
	 * @param type $action
	 */
	protected function redirect($controller, $action)
	{
		header("location:./?p={$controller}/{$action}");
		exit;
	}

}
