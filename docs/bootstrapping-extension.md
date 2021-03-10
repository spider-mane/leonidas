# Bootstrapping an Extension

```php
<?php

use Psr\Container\ContainerInterface;
use WebTheory\Leonidas\Enum\ExtensionType;
use WebTheory\Leonidas\Framework\ModuleInitializer;
use WebTheory\Leonidas\Framework\WpExtension;

// composer autoload
if (file_exists($autoload = __DIR__ . '/vendor/autoload.php')) {
    require $autoload;
}

// required for development purposes only
if (file_exists($development = __DIR__ . '/boot/development.php')) {
    require $development;
}

/** @var ContainerInterface $container */
$container = require 'boot/container.php';

$base = WpExtension::create([
    'name' => 'Extension Name',
    'prefix' => 'pre',
    'path' => __DIR__,
    'base' => plugin_basename(__FILE__),
    'url' => plugin_dir_url(__FILE__),
    'assets' => '/assets/dist',
    'dev' => 'EXTENSION_NAME_DEVELOPMENT',
    'type' => new ExtensionType('plugin'),
    'container' => $container
]);

$extension = new ModuleInitializer($base, $base->config('app.modules'));

$extension->init();
```
