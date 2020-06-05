<?php

namespace Smp;

/**
 * Class Request
 * @package Smp
 */
class Request
{
    protected static $instance;

    protected const METHOD_GET  = 1;
    protected const METHOD_POST = 2;

    /**
     * @return Request
     */
    public static function i()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return bool
     */
    public function isPost()
    {
        return isset($_POST);
    }

    /**
     * @return bool
     */
    public function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    /**
     * @param      $key
     *
     * @return mixed
     */
    public function post($key = null)
    {
        return $key ? $_POST[$key] : $_POST;
    }

    /**
     * @param null $key
     *
     * @return mixed
     */
    public function get($key = null)
    {
        return $key ? $_GET[$key] : $_GET;
    }

    /**
     * @param      $key
     * @param int  $method
     *
     * @return mixed
     */
    protected function getParam($key, $method = self::METHOD_GET)
    {
        if ($method == self::METHOD_GET) {
            return $this->get($key);
        }

        return $this->post($key);
    }

    /**
     * @param      $key
     * @param int  $method
     * @param null $default_value
     *
     * @return int|null
     */
    protected function getIntParam($key, $method = self::METHOD_GET, $default_value = null)
    {
        $value = $this->getParam($key, $method);

        if (!is_numeric($value)) {
            return $default_value;
        }

        return (int)$this->getParam($key, $method);
    }

    /**
     * @param      $key
     * @param null $default_value
     *
     * @return int|null
     */
    public function getInt($key, $default_value = null)
    {
        return $this->getIntParam($key, self::METHOD_GET, $default_value);
    }

    /**
     * @param      $key
     * @param null $default_value
     *
     * @return int|null
     */
    public function postInt($key, $default_value = null)
    {
        return $this->getIntParam($key, self::METHOD_POST, $default_value);
    }

    /**
     * @param      $key
     * @param int  $method
     * @param null $default_value
     *
     * @return float|null
     */
    protected function getFloatParam($key, $method = self::METHOD_GET, $default_value = null)
    {
        $value = $this->getParam($key, $method);

        if (!is_float($value)) {
            return $default_value;
        }

        return (float)$this->getParam($key, $method);
    }

    /**
     * @param      $key
     * @param null $default_value
     *
     * @return float|null
     */
    public function getFloat($key, $default_value = null)
    {
        return $this->getFloatParam($key, self::METHOD_GET, $default_value);
    }

    /**
     * @param      $key
     * @param null $default_value
     *
     * @return float|null
     */
    public function postFloat($key, $default_value = null)
    {
        return $this->getFloatParam($key, self::METHOD_POST, $default_value);
    }

    /**
     * @param      $key
     * @param int  $method
     * @param null $default_value
     *
     * @return mixed
     */
    protected function getParamStr($key, $method = self::METHOD_GET, $default_value = null)
    {
        $value = $this->getParam($key, $method);
        if (!is_string($value)) {
            return $default_value;
        }

        return $value;
    }

    /**
     * @param      $key
     * @param null $default_value
     *
     * @return mixed
     */
    public function getStr($key, $default_value = null)
    {
        return $this->getParamStr($key, self::METHOD_GET, $default_value);
    }

    /**
     * @param      $key
     * @param null $default_value
     *
     * @return mixed
     */
    public function postStr($key, $default_value = null)
    {
        return $this->getParamStr($key, self::METHOD_POST, $default_value);
    }
}