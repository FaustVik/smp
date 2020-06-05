<?php

namespace Smp;

use App\App;

/**
 * Class Controller
 * @package Smp
 */
class Controller
{
    /**@var string $title */
    protected $title;

    protected function render(string $file_name, array $data = [])
    {
        $title  = $this->title;
        $$title = $title;

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $$key = $value;
            }
        }

        $class_c    = App::i()->getCalledClass(2);
        $class_name = mb_strtolower($this->getNameClass($class_c));

        $view_path = App::i()->getParams()['view_path'] . '/' . $class_name . '/' . $file_name . '.php';

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
    private function getNameClass($class_called)
    {
        $ex         = explode('\\', $class_called['class']);
        $class_name = explode('Controller', $ex[2]);

        return $class_name[0];
    }

    /**
     * @return Response
     */
    protected function getResponse()
    {
        return App::i()->getResponse();
    }

    /**
     * @return Request
     */
    protected function getRequest()
    {
        return App::i()->getRequest();
    }
}