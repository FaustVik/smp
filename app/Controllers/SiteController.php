<?php

namespace App\Controllers;

use Smp\Application;
use Smp\Controller;

/**
 * Class SiteController
 * @package App\Controllers
 */
class SiteController extends Controller
{
    /**
     * @return mixed
     * @throws \Exception
     */
    public function actionIndex()
    {
        $this->title = 'Hel';

        var_dump(Application::$app->getRequest()->get());

        var_dump($this->session->get('ff'));

        return $this->render('index',['gg' => 12993]);
    }

    public function actionTest()
    {
      echo 12;
    }
}