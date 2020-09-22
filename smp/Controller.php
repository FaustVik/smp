<?php

namespace Smp;

use Smp\Storage\Session;

/**
 * Class Controller
 * @package Smp
 */
class Controller
{
    /**@var string $title */
    protected $title;

    /**@var Session $session */
    protected $session;

    protected function render(string $file_name, array $data = [])
    {
        $title  = $this->title;
        $$title = $title;

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $$key = $value;
            }
        }

        $class_c    = $this->getCalledClass(2);
        $class_name = mb_strtolower($this->getNameClass($class_c));

        $view_path = Application::$app->view_path . '/' . $class_name . '/' . $file_name . '.php';

        if (!file_exists($view_path)) {
            throw new \Exception('Not found view file path: ' . $view_path);
        }

        return require $view_path;
    }

    /**
     * @param $class_called
     *
     * @return string
     */
    private function getNameClass($class_called): string
    {
        $ex         = explode('\\', $class_called['class']);
        $class_name = explode('Controller', $ex[2]);

        return $class_name[0];
    }

    /**
     * @return Response
     */
    protected function getResponse(): Response
    {
        return Application::$app->getResponse();
    }

    /**
     * @return Request
     */
    protected function getRequest(): Request
    {
        return Application::$app->getRequest();
    }

    /**
     * @param int $offset
     *
     * @return array
     */
    private function getCalledClass($offset = 1): array
    {
        $backtrace = debug_backtrace();

        $caller = null;

        if (isset($backtrace[$offset])) {
            $backtrace = $backtrace[$offset];
            if (isset($backtrace['class'])) {
                $caller['class'] = $backtrace['class'];
            }
            if (isset($backtrace['function'])) {
                $caller['function'] = $backtrace['function'];
            }
        }

        return $caller;
    }

    public function afterAction()
    {

    }

    public function beforeAction()
    {
        if (!$this->session){
            $this->session = new Session();
            $this->session->start();
        }
    }
}