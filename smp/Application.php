<?php

namespace Smp;

/**
 * Class Application
 * @property string $namespace
 * @property array  $db
 * @property string $view_path
 * @property array  $url_manager
 * @property string $layout_path
 * @package Smp
 */
class Application
{
    /** @var array $app -  storage app config */
    public static $app;

    protected const IMPORTANT_CONF = [
        'view_path',
        'namespace',
    ];

    public function __construct(array $config)
    {
        self::$app = $this;

        $this->checkConfig($config);
        $this->setApp(self::$app, $config);
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
}