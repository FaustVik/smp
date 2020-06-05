<?php

namespace Smp;

/**
 * Class Application
 * @package Smp
 */
class Application extends Configure
{
    /** @var array $app -  storage app config */
    public static $app;

    protected static $instance;

    public static function i()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function run(array $config)
    {
        $this->getConfig($config);

        $router = new Router();
        $router->run();
    }

    /**
     * @param array $config
     *
     * @throws \Exception
     */
    protected function getConfig(array $config)
    {
        if (empty($config)) {
            throw new \Error('Not configuration');
        }

        $this->config = $config;
        $this->checkConfig();

        self::$app = $this->config;
    }

    public function close()
    {
        exit(0);
    }
}