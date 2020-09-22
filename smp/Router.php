<?php

namespace Smp;

/**
 * Class Router
 * @author  Victor
 * @version 3.0
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
        $this->setNamespaces();
        $this->parse();
    }

    protected function parse(): void
    {
        $this->checkParams();

        if ($this->uri === '/') {
            $this->controller = $this->setController($this->defaultController);
            $this->action     = $this->setAction($this->defaultAction);
        } else if (!$this->routes($this->uri)) {
            $explode = explode('/', $this->uri);
            if (count($explode) === 2) {
                /** without action */
                $this->controller = $this->setController($explode[1]);
                $this->action     = $this->setAction($this->defaultAction);
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
            $this->controller = $this->setController($this->defaultController);
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

        if (!method_exists($this->controller, $action)) {
            Application::$app->getResponse()->set404();
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