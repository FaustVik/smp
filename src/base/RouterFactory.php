<?php

namespace Smp\base;

use Smp\Smp;

/**
 * Class RouterFactory
 * @package Smp\base
 */
abstract class RouterFactory
{
    public const DEFAULT_CONTROLLER = 'site';
    public const DEFAULT_ACTION     = 'index';

    public const BEFORE_ACTION = 'beforeAction';
    public const AFTER_ACTION  = 'afterAction';

    /**@var string $controller */
    protected $controller;

    /**@var string $action */
    protected $action;

    /**@var array $params */
    protected $params = [];

    /**@var string $namespace */
    protected $namespace;

    /**
     * Run Router
     */
    abstract public function run(): void;

    /**
     * Parse request string
     */
    abstract protected function parse(): void;

    /**
     * After parse run necessary method
     */
    abstract protected function runAction(): void;

    /**
     * @param string $controller_name
     *
     * @return string
     */
    protected function setController(string $controller_name): string
    {
        $controller_name = $this->replacingTheHyphenWithUppercase($controller_name);

        return $this->namespace . '\\' . $controller_name . 'Controller';
    }

    /**
     * @param string $action_name
     *
     * @return string
     */
    protected function setAction(string $action_name): string
    {
        return 'action' . $this->replacingTheHyphenWithUppercase($action_name);
    }

    /**
     * @param string $name
     *
     * @return string
     */
    protected function replacingTheHyphenWithUppercase(string $name): string
    {
        if (strpos($name, '-')) {

            $arr = explode('-', $name);

            $replace_name = '';

            foreach ($arr as $item) {
                $replace_name .= ucfirst($item);
            }

            return ucfirst($replace_name);
        }

        return ucfirst($name);
    }

    /**
     * @throws \ErrorException
     */
    protected function setNamespaces(): void
    {
        $this->namespace = Smp::$app->namespace;

        if (!$this->namespace) {
            throw new \ErrorException('Not found Namespace');
        }
    }
}