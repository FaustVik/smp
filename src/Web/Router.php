<?php

namespace Smp\Web;

use Smp\base\RouterFactory;
use Smp\Helpers\Url;
use Smp\Smp;

/**
 * Class Router
 * @author  Victor
 * @version 3.2
 * @since   10.09.2019
 * @package Smp
 */
class Router extends RouterFactory
{
    /**@var string $uri */
    protected $uri;

    /**
     * @throws \ErrorException
     */
    public function run(): void
    {
        $this->getUri();
        $this->setNamespaces();
        $this->parse();
        $this->runAction();
    }

    protected function getUri(): void
    {
        $this->uri = $_SERVER['REQUEST_URI'];
    }

    protected function parse(): void
    {
        $this->checkParams();

        if ($this->uri === '/') {
            $this->controller = $this->setController(self::DEFAULT_CONTROLLER);
            $this->action     = $this->setAction(self::DEFAULT_ACTION);
        } else if (!$this->routes($this->uri)) {
            $explode = explode('/', $this->uri);
            if (count($explode) === 2) {
                /** without action */
                $this->controller = $this->setController($explode[1]);
                $this->action     = $this->setAction(self::DEFAULT_ACTION);
            } else {
                $this->controller = $this->setController($explode[1]);
                $this->action     = $this->setAction($explode[2]);
            }
        }
    }

    /**
     * Checks if parameters. If there is, it writes to $ this->params.And $ this->uri writes url without parameters
     */
    protected function checkParams(): void
    {
        $params = Url::getQuery($this->uri);

        if ($params) {
            $explode      = explode('?', $this->uri);
            $this->params = Url::getParamsToArray($explode[1]);
            $this->uri    = $explode[0];
        }
    }

    protected function runAction(): void
    {
        /** set default Controller if not found necessary Controller */
        if (!class_exists($this->controller)) {
            $this->controller = $this->setController(self::DEFAULT_CONTROLLER);
        }

        $this->controller = new $this->controller;

        $action = $this->action;

        /** call method beforeAction */
        if (method_exists($this->controller, self::BEFORE_ACTION)) {
            $b_action = self::BEFORE_ACTION;
            $this->controller->$b_action();
        }

        /** set default action if not found necessary action */
        if (!method_exists($this->controller, $this->action)) {
            $action = $this->setAction(self::DEFAULT_ACTION);
        }

        if (!method_exists($this->controller, $action)) {
            Smp::$app->getResponse()->set404();
        }

        /** call method afterAction */
        if (method_exists($this->controller, self::AFTER_ACTION)) {
            $a_action = self::AFTER_ACTION;
            $this->controller->$a_action();
        }

        if (!empty($this->params)) {
            $this->controller->$action($this->params);
        } else {
            $this->controller->$action();
        }
    }

    /**
     * @param $pattern
     *
     * @return bool
     */
    protected function routes($pattern): bool
    {
        $pattern = substr($pattern, 1);

        $rules = Smp::$app->url_manager;

        if (!$rules) {
            return false;
        }

        foreach ($rules as $rule => $real_controller_action) {
            if ($rule === $pattern) {
                [$controller, $action] = explode('/', $real_controller_action);

                $this->controller = $this->setController($controller);
                $this->action     = $this->setAction($action);

                return true;
            }
        }
        return false;
    }
}