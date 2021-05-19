<?php

namespace Smp\Helpers;

use Smp\Smp;

/**
 * Class Url
 * @package Smp\Helpers
 */
class Url
{
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
        return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/';
    }

    /**
     * @param string $route
     * @param array  $params
     *
     * @return int|string
     */
    public static function toRoute(string $route, array $params = [])
    {
        $rules = Smp::$app->url_manager;

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
                    $url             .= '?' . $key . '=' . $value;
                    $first_parameter = false;
                    continue;
                }

                $url .= '&' . $key . '=' . $value;
            }
        }

        return self::buildSchemeWithHost() . $url;
    }

    /**
     * @param string $query
     *
     * @return array
     */
    public static function getParamsToArray(string $query): array
    {
        $params_arr = explode('&', $query);

        if (!is_array($params_arr)) {
            return [];
        }

        $params = [];

        foreach ($params_arr as $data) {
            $ex = explode('=', $data);

            $params[$ex[0]] = $ex[1] ?? null;
        }

        return $params;
    }

    /**
     * @return mixed
     */
    public static function getUri()
    {
        return $_SERVER["REQUEST_URI"];
    }
}