<?php

namespace Smp\Helpers;

use Smp\Application;

/**
 * Class Url
 * @package Smp\Helpers
 */
class Url
{
    public const SCHEME_HTTP  = 'http://';
    public const SCHEME_HTTPS = 'https://';

    /**
     * @param $data
     *
     * @return string
     */
    public static function buildQuery($data): string
    {
        return http_build_query($data);
    }

    /**
     * @param string $url
     * @param int    $component
     *
     * @return array|false|int|string|null
     */
    public static function parse(string $url, int $component = -1)
    {
        return parse_url($url, $component);
    }

    /**
     * @param $url
     *
     * @return array|false|int|string|null
     */
    public static function getPort($url)
    {
        return self::parse($url, PHP_URL_PORT);
    }

    /**
     * @param $url
     *
     * @return array|false|int|string|null
     */
    public static function getQuery($url)
    {
        return self::parse($url, PHP_URL_QUERY);
    }

    /**
     * @param $url
     *
     * @return array|false|int|string|null
     */
    public static function getScheme($url)
    {
        return self::parse($url, PHP_URL_SCHEME);
    }

    /**
     * @return string
     */
    public static function buildSchemeWithHost(): string
    {
        if (SMP_DEBUG){
            return  self::SCHEME_HTTP . $_SERVER['SERVER_NAME'] . '/';
        }

        return self::SCHEME_HTTPS . $_SERVER['SERVER_NAME'] . '/';
    }

    /**
     * @param       $route
     * @param array $params
     *
     * @return int|string
     */
    public static function toRoute($route, array $params = [])
    {
        $rules = Application::$app->url_manager;

        $url = '';

        foreach ($rules as $rule => $real_controller_action) {
            if ($real_controller_action === $route) {
                $url = $rule;
            }
        }

        if ($url === '') {
            $url = $route;
        }

        $first_parameter = true;

        if (!empty($params)) {
            foreach ($params as $key => $value) {
                if ($first_parameter) {
                    $url .= '?' . $key . '=' . $value;
                    $first_parameter = false;
                } else {
                    $url .= '&' . $key . '=' . $value;
                }
            }
        }

        return $url;
    }
}