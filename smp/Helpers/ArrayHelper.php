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
}