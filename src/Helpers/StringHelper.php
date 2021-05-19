<?php

namespace Smp\Helpers;

/**
 * Class StringHelper
 * @package Smp\Helpers
 */
class StringHelper
{
    /**
     * @param string $haystack
     * @param string $needle
     *
     * @return array
     */
    public static function strpos_all(string $haystack, string $needle): array
    {
        $offset  = 0;
        $all_pos = [];

        while (($pos = strpos($haystack, $needle, $offset)) !== false) {
            $offset    = $pos + 1;
            $all_pos[] = $pos;
        }
        return $all_pos;
    }

    /**
     * @param        $path
     * @param string $suffix
     *
     * @return string
     */
    public static function basename($path, $suffix = ''): string
    {
        if (($len = mb_strlen($suffix)) > 0 && mb_substr($path, -$len) === $suffix) {
            $path = mb_substr($path, 0, -$len);
        }
        $path = rtrim(str_replace('\\', '/', $path), '/\\');
        if (($pos = mb_strrpos($path, '/')) !== false) {
            return mb_substr($path, $pos + 1);
        }

        return $path;
    }
}