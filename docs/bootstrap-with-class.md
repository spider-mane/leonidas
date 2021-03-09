# Bootstrap an Extension using a Bootstrapping Class

```php
<?php

use YourVendorName\YourExtensionName\Extension;

// composer autoload
if (file_exists($autoload = __DIR__ . '/vendor/autoload.php')) {
    require $autoload;
}

// required for development purposes only
if (file_exists($development = __DIR__ . '/boot/development.php')) {
    require $development;
}

// bootstrap
Extension::init([
    'path' => __DIR__,
    'base' => plugin_basename(__DIR__),
    'uri' => plugin_dir_url(__FILE__),
]);
```
