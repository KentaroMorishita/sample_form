<?php

namespace App\Controllers;

use App\Libs\Csrf;
use Twig_Environment;
use Twig_Loader_Filesystem;
use Twig_SimpleFunction;

/**
 * Class Controller
 * @package App\Controllers
 */
class Controller
{

    /**
     *
     */
    const REQUEST_POST = 'POST';
    /**
     *
     */
    const REQUEST_GET = 'GET';

    /**
     * @var \Twig_Environment
     */
    protected $view;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

        $loader = new Twig_Loader_Filesystem(VIEW_PATH);
        $this->view = new Twig_Environment($loader, [
            'cache' => ROOT_PATH . '/cache/',
            'debug' => true,
        ]);
        $this->view->addFunction(new Twig_SimpleFunction('Csrf', function ($method) {
            return Csrf::$method();
        }));

        \App\Libs\DB::connect();
    }

    /**
     * @param $template_path
     * @param array $data
     * @return mixed
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    protected function view($template_path, $data = [])
    {
        $template = $this->view->loadTemplate($template_path);
        return $template->display($data);
    }

    /**
     * @return mixed
     */
    protected function post()
    {
        return filter_input_array(INPUT_POST);
    }

    /**
     * @return mixed
     */
    protected function get()
    {
        $get = filter_input_array(INPUT_GET);
        unset($get['p']);
        return $get;
    }

    /**
     * @param $path
     */
    protected function redirect($path)
    {
        $protocol = empty(filter_input(INPUT_SERVER, 'HTTPS')) ? 'http://' : 'https://';

        $host = filter_input(INPUT_SERVER, 'HTTP_HOST');
        header("location:{$protocol}{$host}{$path}");
        exit;
    }
}
