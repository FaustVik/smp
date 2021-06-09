Simple mvc (SMP)
============================

A simple library for deploying a simple site. Web and console applications are available out of the box.

### Installation

```sh
composer require rosbergvik/smp:dev-master
```

### Example

[Example](https://github.com/FaustVik/smp/tree/master/test) of creating a simple mvc application using SMP.

P.S.
Run console controller
```shell
php your_console_endpoint.php  controller/action [params] (php console.php test/action 'fist_params')
``` 
### Configs

For a web application, the required parameters are:

```php
return [
    'namespace'   => 'your_namespace',
    'view_path'   => 'path_to_views',
    'layout_path'   => 'path_to_layouts',
    'url_manager' => [
        'alias' => 'controller/action'
    ],
];
```

For the console application, the required parameters are:

```php
return [
     'namespace'   => 'your_namespace',
];
```

### Endpoints

Web:
```php 
$vendor_path = dirname(__DIR__, 2);

$basePath = dirname(__DIR__);

require $vendor_path . '/vendor/autoload.php';

$config = require $basePath . '/config/main.php';

(new Smp\Web\Application($config))->run();
```

Console:

```php 
$vendor_path = dirname(__DIR__);

$basePath = __DIR__;

require $vendor_path . '/vendor/autoload.php';

$config = require $basePath . '/config/console.php';

(new \Smp\Console\Application($config))->run();
```
