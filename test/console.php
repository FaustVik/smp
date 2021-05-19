<?php
$vendor_path = dirname(__DIR__);

$basePath = __DIR__;

require $vendor_path . '/vendor/autoload.php';

$config = require $basePath . '/config/console.php';

defined('SMP_DEBUG') or define('SMP_DEBUG', true);

(new \Smp\Console\Application($config))->run();