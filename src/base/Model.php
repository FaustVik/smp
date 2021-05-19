<?php

namespace Smp\base;

use Smp\Helpers\StringHelper;

/**
 * Class Model
 * @package Smp\base
 */
class Model
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return StringHelper::basename(static::class);
    }
}