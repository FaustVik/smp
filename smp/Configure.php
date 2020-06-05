<?php

namespace Smp;

/**
 * Class Configure
 * @package Smp
 */
class Configure
{
    /**@var array $config */
    public $config = [];

    protected const CONF = [
        'view_path',
        'namespace',
    ];

    protected function checkConfig()
    {
        $keys = array_keys($this->config);

        foreach (self::CONF as $conf_key){
            if (!in_array($conf_key, $keys)){
                throw new \Exception('Not found param ' . $conf_key);
            }
        }
    }
}