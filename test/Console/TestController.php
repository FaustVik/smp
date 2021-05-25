<?php

namespace App\Console;

use Smp\Console\Controller;

/**
 * Class TestController
 * @package App\Console
 */
class TestController extends Controller
{
    public function actionIndex()
    {
        var_dump('Index');
    }
}