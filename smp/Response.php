<?php

namespace Smp;

/**
 * Class Response
 * @package Smp
 */
class Response
{
    protected static $instance;

    /**
     * @return Response
     */
    public static function i()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param string $message
     *
     */
    public function set404($message = '')
    {
        header('HTTP/1.0 404 Not Found', true, 404);

        $path = Application::$app->layout_path . '/error/404.html';

        $contents = file_get_contents($path, TRUE);

        exit($contents);
    }

    /**
     * @param string $message
     *
     */
    public function set403($message = '')
    {
        header('HTTP/1.0 403 Forbidden', true, 403);

        $path = Application::$app->layout_path . '/error/403.html';

        $contents = file_get_contents($path, TRUE);

        exit($contents);
    }
}