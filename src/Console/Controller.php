<?php

namespace Smp\Console;

/**
 * Class Controller
 * @package Smp\Console
 */
class Controller extends \Smp\base\Controller
{
    /**@var \DateTime $start */
    protected $start;

    public function afterAction()
    {
        $this->start = new \DateTime();
        echo 'Start: ' . PHP_EOL;
    }

    public function beforeAction()
    {
        echo 'End. Time taken: ' . (microtime() - $this->start->getTimestamp()) . PHP_EOL;
    }
}