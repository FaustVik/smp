<?php

namespace App;

use Smp\DataBase;
use Smp\Request;
use Smp\Response;
use Smp\Storage\Cookie;
use Smp\Storage\Session;

/**
 * Class App
 * @package App
 */
class App
{
    protected static $instance;

    /**
     * @return App
     */
    public static function i()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $config = [];

        $config_path = __DIR__ . '/config/main.php';

        if (is_file($config_path)) {
            $config = require $config_path;
        }

        return $config;
    }

    public function getCalledClass($offset = 1)
    {
        $backtrace = debug_backtrace();

        $caller = null;

        if (isset($backtrace[$offset])) {
            $backtrace = $backtrace[$offset];
            if (isset($backtrace['class'])) {
                $caller['class'] = $backtrace['class'];
            }
            if (isset($backtrace['function'])) {
                $caller['function'] = $backtrace['function'];
            }
        }

        return $caller;
    }
}