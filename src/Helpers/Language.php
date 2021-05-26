<?php

namespace Smp\Helpers;

/**
 * Class Language
 * @package Smp\Helpers
 */
class Language
{
    /**
     * @param array  $available_languages
     * @param string $http_accept_language
     *
     * @return array
     */
    public static function getPreferredLanguage(array $available_languages, string $http_accept_language): array
    {
        $available_languages = array_flip($available_languages);

        $languages = [];

        preg_match_all('~([\w-]+)(?:[^,\d]+([\d.]+))?~', strtolower($http_accept_language), $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {

            [$a, $b] = explode('-', $match[1]) + ['', ''];
            $value = isset($match[2]) ? (float)$match[2] : 1.0;

            if (isset($available_languages[$match[1]])) {
                $languages[$match[1]] = $value;
                continue;
            }

            if (isset($available_languages[$a])) {
                $languages[$a] = $value - 0.1;
            }

        }
        arsort($languages);

        return $languages;
    }
}