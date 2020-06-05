<?php

namespace App\Controllers;

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

        return $this->render('index',['gg' => 12993]);
    }
}