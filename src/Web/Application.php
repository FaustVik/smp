<?php

namespace Smp\Web;

use Smp\base\Application as baseApplication;
use Smp\Request;
use Smp\Response;
use Smp\Router;
use Smp\Storage\Session;

/**
 * Class Application
 * @property array  url_manager
 * @property string $layout_path
 * @property string $view_path
 * @package Smp\Web
 */
class Application extends baseApplication
{
    /**
     * @throws \ErrorException
     */
    public function run(): void
    {
        $this->getSession()->start();
        $router = new Router();
        $router->run();
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return Response::i();
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return Request::i();
    }

    /**
     * @return Session
     */
    public function getSession(): Session
    {
        return new Session();
    }
}