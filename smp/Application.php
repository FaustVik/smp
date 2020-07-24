<?php

namespace Smp;

/**
 * Class Application
 * @property string $namespace
 * @property array  $db
 * @property string $view_path
 * @property array  $url_manager
 * @property string $layout_path
 * @property array  $params
 * @package Smp
 */
class Application extends Components
{
    /** @var array $app -  storage app config */
    public static $app;

    /**@var  array $params */
    public $params = [];

    protected const IMPORTANT_CONF = [
        'view_path',
        'namespace',
    ];

    public function __construct(array $config)
    {
        self::$app = $this;

        $this->checkConfig($config);
        $this->setApp(self::$app, $config);

        $this->params = $config;
    }

    /**
     * @param array $config
     *
     * @throws AppError
     */
    protected function checkConfig(array $config): void
    {
        $keys = array_keys($config);

        foreach (self::IMPORTANT_CONF as $conf_key) {
            if (!in_array($conf_key, $keys, true)) {
                throw new AppError('Not found param ' . $conf_key);
            }
        }
    }

    /**
     * @throws \ErrorException
     */
    public function run(): void
    {
        $router = new Router();
        $router->run();
    }

    /**
     * @param object $object
     * @param array  $config
     */
    protected function setApp(object $object, array $config): void
    {
        foreach ($config as $name => $value) {
            $object->$name = $value;
        }
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param array $params
     */
    public function setParams(array $params): void
    {
        $this->params = $params;
    }
}