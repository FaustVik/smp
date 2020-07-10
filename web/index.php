<?php

$basePath = dirname(__DIR__);

require $basePath. '/vendor/autoload.php';

$config = require $basePath . '/app/config/main.php';

defined('SMP_DEBUG') or define('SMP_DEBUG', true);

(new \Smp\Application($config))->run();