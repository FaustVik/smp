<?php

$basePath = dirname(__DIR__);

require $basePath. '/vendor/autoload.php';

$config = require $basePath . '/app/config/main.php';

(new \Smp\Application())->run($config);