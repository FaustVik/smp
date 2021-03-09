<?php

namespace Smp;

/**
 * Class Router
 * @author  Victor
 * @version 3.1
 * @since   10.09.2019
 * @package Smp
 */
class Router
{
    protected const DEFAULT_CONTROLLER = 'site';
    protected const DEFAULT_ACTION     = 'index';

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
        $this->getUri();
        $this->setNamespaces();
        $this->parse();
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

        $this->runAction();
    }

    /**
     * Checks if parameters. If there is, it writes to $ this->params.And $ this->uri writes url without parameters
     */
    protected function checkParams(): void
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
     * @param string $params_string
     */
    protected function setParams(string $params_string): void
    {
        $params_arr = explode('&', $params_string);

        if (!is_array($params_arr)) {
            return;
        }

        foreach ($params_arr as $data) {
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
    protected function setController($controller_name): string
    {
        return $this->namespace . '\\' . ucfirst($controller_name) . 'Controller';
    }

    /**
     * @param string $action_name
     *
     * @return string
     */
    protected function setAction(string $action_name): string
    {
        $ex = explode('-', $action_name);

        if (count($ex) > 1) {
            $action = 'action';

            foreach ($ex as $item) {
                $action .= ucfirst($item);
            }

            return $action;
        }

        return 'action' . ucfirst($action_name);
    }

    protected function runAction(): void
    {
        /** set default Controller if not found necessary Controller */
        if (!class_exists($this->controller)) {
            $this->controller = $this->setController(self::DEFAULT_CONTROLLER);
        }

        $this->controller = new $this->controller;

        $action = $this->action;

        /** set default action if not found necessary action */
        if (!method_exists($this->controller, $this->action)) {
            $action = $this->setAction(self::DEFAULT_ACTION);
        }

        if (!method_exists($this->controller, $action)) {
            Application::$app->getResponse()->set404();
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

        $rules = Application::$app->url_manager;

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

    /**
     * @throws \ErrorException
     */
    protected function setNamespaces(): void
    {
        $this->namespace = Application::$app->namespace;

        if (!$this->namespace) {
            throw new \ErrorException('Not found Namespace');
        }
    }
}