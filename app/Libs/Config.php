<?php

namespace App\Libs;

use Symfony\Component\Yaml\Parser;

/**
 * Class Config
 * @package App\Libs
 */
class Config
{

    /**
     * @param $route
     * @return mixed
     */
    public static function get($route)
    {
        $parser = new Parser();
        $config = $parser->parse(file_get_contents(APP_PATH . DS . 'config.yml'));

        $values = preg_split('/\./', $route, -1, PREG_SPLIT_NO_EMPTY);
        $key = array_pop($values);

        return $config[$key];
    }

}
