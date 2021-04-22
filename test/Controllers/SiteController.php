<?php

namespace App\Controllers;

use Smp\Helpers\Url;
use Smp\Web\Controller;

/**
 * Class SiteController
 * @package App\Controllers
 */
class SiteController extends Controller
{
    public function actionIndex()
    {
        var_dump(Url::getQuery(Url::getUri()));
        exit;
    }
}