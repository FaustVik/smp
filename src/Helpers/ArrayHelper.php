<?php

namespace Smp\Helpers;

/**
 * Class ArrayHelper
 * @package Smp\Helpers
 */
class ArrayHelper
{
    /**
     * @param     $array
     * @param     $column
     * @param int $sort_type
     */
    public static function sortByColumn(&$array, $column, $sort_type = SORT_ASC): void
    {
        $sort_column = [];

        foreach ($array as $key => $row) {
            $sort_column[$key] = $row[$column];
        }

        array_multisort($sort_column, $sort_type, $array);
    }

    /**
     * @param string $mask
     * @param array  $array
     * @param bool   $remove_from_source
     *
     * @return array
     */
    public static function getValueByMask(string $mask, array &$array, bool $remove_from_source = true): array
    {
        $find_elements = [];

        foreach ($array as $key => $value) {
            if (strpos($key, $mask) !== false) {
                $find_elements[$key] = $value;

                if ($remove_from_source) {
                    unset($array[$key]);
                }
            }
        }

        return $find_elements;
    }
}