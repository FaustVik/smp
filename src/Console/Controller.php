<?php

namespace Smp\Console;

/**
 * Class Controller
 * @package Smp\Console
 */
class Controller extends \Smp\base\Controller
{
    /**@var float $start */
    protected $start;

    public function afterAction()
    {
        echo 'End. Time taken: ' . round((microtime(true) - $this->start), 4) . PHP_EOL;
    }

    public function beforeAction()
    {
        $this->start = microtime(true);
        echo 'Start: ' . PHP_EOL;
    }

    /**
     * @param string $message
     * @param false  $default
     *
     * @return bool|mixed
     */
    public function confirm(string $message, bool $default = false)
    {
        while (true) {
            static::stdout($message . ' (yes|no) [' . ($default ? 'yes' : 'no') . ']:');
            $input = trim(static::stdin());

            if (empty($input)) {
                return $default;
            }

            if (!strcasecmp($input, 'y') || !strcasecmp($input, 'yes')) {
                return true;
            }

            if (!strcasecmp($input, 'n') || !strcasecmp($input, 'no')) {
                return false;
            }
        }
    }

    /**
     * @param false $raw
     *
     * @return false|string
     */
    public static function stdin(bool $raw = false)
    {
        return $raw ? fgets(\STDIN) : rtrim(fgets(\STDIN), PHP_EOL);
    }

    /**
     * @param string $string
     *
     * @return false|int
     */
    public static function stdout(string $string)
    {
        return fwrite(\STDOUT, $string);
    }
}