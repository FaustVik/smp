<?php

namespace Smp\Web;

use Smp\Application;

/**
 * Class Controller
 * @package Smp\Web
 */
class Controller extends \Smp\base\Controller
{
    /**@var string $title */
    public $title;

    /**@var string $layout */
    public $layout;

    /**@var  bool $include_layouts возможность отключить соединение header + file + footer */
    public $include_layouts = true;

    /**@var string $layout_path */
    private $layout_path;

    public function __construct()
    {
        $this->layout_path = Application::$app->layout_path;
    }

    /**
     * @param string $filename
     * @param array  $params
     *
     * @return string
     * @throws \Exception
     */
    public function render(string $filename, array $params = []): string
    {
        if (!empty($params)) {
            extract($params, EXTR_SKIP);
        }

        $content = '';

        ob_start();

        $path_to_content     = Application::$app->view_path . '/' . $this->getClassName() . '/' . $filename . '.php';
        $path_to_head_file   = $this->getPathToLayoutsFile('head');
        $path_to_footer_file = $this->getPathToLayoutsFile('footer');

        if ($this->checkFileExist($path_to_head_file)) {
            require $path_to_head_file;
            $content .= ob_get_contents();
        }

        if ($this->checkFileExist($path_to_content)) {
            require $path_to_content;
            $content .= ob_get_contents();
        } else {
            throw new \Exception('Not found path: ' . $path_to_content);
        }

        if ($this->checkFileExist($path_to_footer_file)) {
            require $path_to_footer_file;
            $content .= ob_get_contents();
        }

        ob_end_flush();

        return $content;
    }

    /**
     * @param string $file_name
     *
     * @return string
     */
    private function getPathToLayoutsFile(string $file_name): string
    {
        if ($this->include_layouts) {
            return $this->layout_path . '/' . $this->layout . '/' . $file_name . '.php';
        }

        return '';
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    private function checkFileExist(string $path): bool
    {
        return $path !== '' && is_file($path) && is_readable($path);
    }
}