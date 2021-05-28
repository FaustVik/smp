<?php

namespace Smp\Console;

/**
 * Class Application
 * @package Smp\Console
 */
class Application extends \Smp\base\Application
{
    public function __construct(array $config)
    {
        parent::__construct($config);
        $this->init();
    }

    public function run(): void
    {
        $router = new Router();
        $router->run();
    }

    protected function init(): void
    {
        Request::i()->getParams();
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return Request::i();
    }

    public function close(): void
    {
        exit(0);
    }
}