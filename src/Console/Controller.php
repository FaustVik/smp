<?php

namespace Smp\Console;

/**
 * Class Controller
 * @package Smp\Console
 */
class Controller extends \Smp\base\Controller
{
    /**@var float $start */
    protected $start;

    public function afterAction()
    {
        echo 'End. Time taken: ' . round((microtime(true) - $this->start), 4) . PHP_EOL;
    }

    public function beforeAction()
    {
        $this->start = microtime(true);
        echo 'Start: ' . PHP_EOL;
    }
}