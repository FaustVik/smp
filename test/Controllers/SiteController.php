<?php

namespace SmpTest\Controllers;

use Smp\Web\Controller;

/**
 * Class SiteController
 * @package App\Controllers
 */
class SiteController extends Controller
{
    /**
     * @return string
     * @throws \Exception
     */
    public function actionIndex(): string
    {
        $this->title = 'Index Page';

        $name = 'Your name';

        return $this->render('index', [
            'name' => $name,
        ]);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionTest(): string
    {
        $this->title = '';

        $params = [
            'Line',
            'Two line',
        ];

        return $this->render('test', [
            'params' => $params,
        ]);
    }
}