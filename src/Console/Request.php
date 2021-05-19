<?php

namespace Smp\Console;

/**
 * Class Request
 * @package Smp\Console
 */
class Request
{
    /**@var array $params */
    private $params;

    public static $instance;

    /**
     * @return Request
     */
    public static function i(): Request
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        if ($this->params === null) {
            if (isset($_SERVER['argv']) && !empty($_SERVER['argv'])) {
                $this->params = $_SERVER['argv'];
                array_shift($this->params);
            } else {
                $this->params = [];
            }
        }

        return $this->params;
    }

    /**
     * @param array $params
     */
    protected function setParams(array $params): void
    {
        $this->params = $params;
    }
}