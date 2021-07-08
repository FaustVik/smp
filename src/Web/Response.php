<?php

namespace Smp\Web;

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
    public static function i(): Response
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
    public function set404(string $message = '')
    {
        header('HTTP/1.0 404 Not Found', true, 404);
    }

    /**
     * @param string $message
     *
     */
    public function set403(string $message = '')
    {
        header('HTTP/1.0 403 Forbidden', true, 403);
    }
}