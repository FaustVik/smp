<?php

namespace Smp\Helpers;

/**
 * Class Directory
 * @package Smp\Helpers
 */
class Directory
{
    /**
     * @param string $path
     */
    public static function creatingNestedDirectories(string $path): void
    {
        $tags  = explode('/', $path);
        $mkDir = "";

        foreach ($tags as $folder) {
            $mkDir .= $folder . "/";
            self::createDir($mkDir);
        }
    }

    /**
     * @param string $path
     */
    public static function createDir(string $path): void
    {
        if (!is_dir($path) && !mkdir($path) && !is_dir($path)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $path));
        }
    }

    /**
     * @param string $path
     */
    public static function deleteDir(string $path): void
    {
        $dir = opendir($path);
        while (false !== ($file = readdir($dir))) {
            if (($file !== '.') && ($file !== '..')) {
                if (is_dir($path . '/' . $file)) {
                    self::deleteDir($path . '/' . $file);
                } else {
                    unlink($path . '/' . $file);
                }
            }
        }
        closedir($dir);
        rmdir($path);
    }
}