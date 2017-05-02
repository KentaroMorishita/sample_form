<?php

namespace App\Controllers;

use Twig_Loader_Filesystem;
use Twig_Environment;

class Controller
{

	protected $input;
	protected $view;

	public function __construct()
	{
		$this->input = filter_input_array(INPUT_REQUEST);

		$loader = new Twig_Loader_Filesystem(VIEW_PATH);
		$this->view = new Twig_Environment($loader, [
			'cache' => ROOT_PATH . '/cache/',
			'debug' => true
		]);
	}

	protected function view($template_path, $data = [])
	{
		$template = $this->view->loadTemplate($template_path);
		return $template->display($data);
	}

}
