<?php

namespace Smp;

/**
 * Class View
 * @package Smp
 */
class View
{
    /**
     * @return mixed
     */
    public static function getHead()
    {
        return require Application::$app->layout_path . 'head.php';
    }

    /**
     * @return mixed
     */
    public static function getFooter()
    {
        return require Application::$app->layout_path . 'footer.php';
    }
}