<?php

namespace Smp\Console;

use Smp\base\RouterFactory;
use Smp\Smp;

/**
 * Class Router
 * @package Smp\Console
 */
class Router extends RouterFactory
{
    /**
     * @throws \ErrorException
     */
    public function run(): void
    {
        $this->setNamespaces();
        $this->parse();
        $this->runAction();
    }

    protected function parse(): void
    {
        $this->params = Smp::$app->getRequest()->getParams();

        [$controller, $action] = explode('/', $this->params[0]);

        if ($controller && $action) {
            $this->controller = $this->setController($controller);
            $this->action     = $this->setAction($action);
        } elseif ($controller) {
            $this->controller = $this->setController($controller);
            $this->action     = $this->setAction(self::DEFAULT_ACTION);
        } else {
            echo "Not found class";
            Smp::$app->close();
        }
    }

    protected function runAction(): void
    {
        if (!class_exists($this->controller)) {
            echo "Not found class";
            Smp::$app->close();
        }

        $controller = new $this->controller;

        $before = self::BEFORE_ACTION;
        $after  = self::AFTER_ACTION;

        $controller->$before();

        $action = $this->action;

        if (method_exists($controller, $action)) {
            if (!empty($this->params)) {
                call_user_func_array([$controller, $action], $this->params);
            } else {
                $controller->$action();
            }

            $controller->$after();
        } else {
            echo'Method not found';
            Smp::$app->close();
        }
    }
}