<?php

namespace Smp;

use App\App;

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
        $view_path = App::i()->getParams()['view_path'];

        return require $view_path . '/layouts/head.php';
    }

    /**
     * @return mixed
     */
    public static function getFooter()
    {
        $view_path = App::i()->getParams()['view_path'];

        return require $view_path . '/layouts/footer.php';
    }
}