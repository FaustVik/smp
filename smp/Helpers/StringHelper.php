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
}