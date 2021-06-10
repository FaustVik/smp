<?php

$vendor_path = dirname(__DIR__, 2);
$basePath    = dirname(__DIR__);

require $vendor_path . '/vendor/autoload.php';
$config = require $basePath . '/config/main.php';
(new Smp\Web\Application($config))->run();