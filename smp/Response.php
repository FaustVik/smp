<?php

namespace Smp;

use HttpException;

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
     * @throws HttpException
     */
    public function set404($message = '')
    {
        throw new HttpException(404, $message);
    }

    /**
     * @param string $message
     *
     * @throws HttpException
     */
    public function set403($message = '')
    {
        throw new HttpException(403, $message);
    }
}