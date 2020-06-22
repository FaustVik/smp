<?php

namespace Smp;

/**
 * Class Router
 * @author  Victor
 * @version 2.2
 * @since   10.09.2019
 * @package Smp
 */
class Router
{
    /**@var string $defaultController */
    protected $defaultController = 'site';

    /**@var string $defaultAction */
    protected $defaultAction = 'index';

    /**@var string $beforeAction */
    protected $beforeAction = 'beforeAction';

    /**@var string $afterAction */
    protected $afterAction = 'afterAction';

    /**@var string $uri */
    protected $uri;

    /**@var string $controller */
    protected $controller;

    /**@var string $action */
    protected $action;

    /**@var array $params */
    protected $params = [];

    /**@var string $namespace */
    protected $namespace;

    /**
     * @throws \ErrorException
     */
    public function run(): void
    {
        $this->uri = $_SERVER['REQUEST_URI'];

        $this->namespace = Application::$app->namespace;

        if (!$this->namespace) {
            throw new \ErrorException('Not found Namespace');
        }

        $this->parse();
    }

    protected function parse(): void
    {
        if ($this->uri === '/') {
            $this->WorkWithParams();

            $this->controller = $this->setNamespaces($this->defaultController);
            $this->action     = $this->setAction($this->defaultAction);
        } else {
            $this->WorkWithParams();

            if (!$this->routes($this->uri)) {
                $explode = explode('/', $this->uri);

                if (count($explode) === 2) {
                    /** without action */
                    $this->controller = $this->setNamespaces($explode[1]);
                    $this->action     = $this->setAction($this->defaultAction);
                } else {
                    $this->controller = $this->setNamespaces($explode[1]);
                    $this->action     = $this->setAction($explode[2]);
                }
            }
        }

        $this->runAction();
    }

    /**
     * Checks if parameters. If there is, it writes to $ this->params.And $ this->uri writes url without parameters
     */
    protected function WorkWithParams(): void
    {
        $explode = explode('?', $this->uri);

        if (isset($explode[1])) {
            $this->setParams($explode[1]);
            $this->uri = $explode[0];
        }
    }

    /**
     * Set params
     *
     * @param string $params
     */
    protected function setParams(string $params): void
    {
        $params = explode('&', $params);

        foreach ($params as $data) {
            $ex = explode('=', $data);

            if (isset($ex[1])) {
                $key   = $ex[0];
                $value = $ex[1];

                $this->params[$key] = $value;
            }
        }
    }

    /**
     * @param $controller_name
     *
     * @return string
     */
    protected function setNamespaces($controller_name): string
    {
        return $this->namespace . '\\' . ucfirst($controller_name) . 'Controller';
    }

    /**
     * @param $action_name
     *
     * @return string
     */
    protected function setAction($action_name): string
    {
        return 'action' . ucfirst($action_name);
    }

    protected function runAction(): void
    {
        /** set default Controller if not found necessary Controller */
        if (!class_exists($this->controller)) {
            $this->controller = $this->setNamespaces($this->defaultController);
        }

        $this->controller = new $this->controller;

        /** call method beforeAction  */
        if (method_exists($this->controller, $this->beforeAction)) {
            $b_action = $this->beforeAction;
            $this->controller->$b_action();
        }

        $action = $this->action;

        /** set default action if not found necessary action */
        if (!method_exists($this->controller, $this->action)) {
            $action = $this->setAction($this->defaultAction);
        }

        if (!empty($this->params)) {
            $this->controller->$action($this->params);
        } else {
            $this->controller->$action();
        }

        /** call method afterAction */
        if (method_exists($this->controller, $this->afterAction)) {
            $a_action = $this->afterAction;
            $this->controller->$a_action();
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

        $rules = Application::$app->url_manager;

        foreach ($rules as $rule => $real_controller_action) {
            if ($rule === $pattern) {
                [$controller, $action] = explode('/', $real_controller_action);

                $this->controller = $this->setNamespaces($controller);
                $this->action     = $this->setAction($action);

                return true;
            }
        }
        return false;
    }
}