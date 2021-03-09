<?php

namespace Smp\base;

/**
 * Class Controller
 * @package Smp\base
 */
class Controller
{
    public function beforeAction(): void
    {

    }

    public function afterAction(): void
    {

    }

    /**
     * @param $method
     * @param $arguments
     *
     * @return bool
     * @throws \Exception
     */
    public function __call($method, $arguments): bool
    {
        if (method_exists($this, $method)) {
            $this->beforeAction();
            $result = call_user_func_array([$this, $method], $arguments);
            $this->afterAction();
            return $result;
        }

        throw new \Exception('Calling unknown method: ' . $method);
    }

    /**
     * @return string
     */
    protected function getClassName(): string
    {
        $explode = explode('\\', static::class);

        return strtolower(str_replace('Controller', '', $explode[count($explode) - 1]));
    }
}