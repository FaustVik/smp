<?php

namespace Smp\base;

use Smp\Smp;
use Smp\Storage\Database;

/**
 * Class Application
 * @property array  $db
 * @property string $namespace
 * @package Smp\base
 */
abstract class Application
{
    /**
     * Application constructor.
     *
     * @param array $config
     *
     * @throws AppException
     */
    public function __construct(array $config)
    {
        if (empty($config)) {
            throw new AppException('Empty configs');
        }

        Smp::$app = $this;
        $this->setApp($this, $config);
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

    public function getDb(): DataBase
    {
        return new DataBase();
    }

    abstract public function run(): void;
}