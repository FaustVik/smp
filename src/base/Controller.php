<?php

namespace Smp\base;

/**
 * Class Controller
 * @package Smp\base
 */
class Controller
{
    public function beforeAction()
    {
    }

    public function afterAction()
    {
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