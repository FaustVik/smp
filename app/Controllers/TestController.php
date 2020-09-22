<?php

namespace App\Controllers;

use Smp\Controller;

/**
 * Class TestController
 * @package App\Controllers
 */
class TestController extends BaseController
{
    /**
     * @return mixed
     * @throws \Exception
     */
    public function actionTestRoute()
    {
        $param = $this->getRequest()->getInt('f');
var_dump(33);
        $this->title = 'test';

        return $this->render('test', [
            'param' => $param,
        ]);
    }

    public function actionWowThisMagic()
    {
        var_dump('llll');
    }
}