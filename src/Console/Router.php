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
        $params = Smp::$app->getRequest()->getParams();

        $explode = explode('/', $params[0]);
        unset($params[0]);

        $this->params = $params;

        if (count($explode) === 2) {
            /** without action */
            $this->controller = $this->setController($explode[1]);
            $this->action     = $this->setAction(self::DEFAULT_ACTION);
        } else {
            $this->controller = $this->setController($explode[1]);
            $this->action     = $this->setAction($explode[2]);
        }
    }

    protected function runAction(): void
    {
        if (!class_exists($this->controller)) {
            echo "Not found";
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
            echo('Method not found');
            Smp::$app->close();
        }
    }
}