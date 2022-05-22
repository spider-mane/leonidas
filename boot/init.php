<?php

defined('ABSPATH') || exit;

$root = dirname(__DIR__, 1);

/**
 *==========================================================================
 * Composer autoloader
 *==========================================================================
 *
 *
 *
 */
if (!file_exists($autoload = "$root/vendor/autoload.php")) {
    throw new RuntimeException(
        "Autoloader not found. Don't forget to run `composer install` in the console."
    );
}

require_once $autoload;

/**
 *==========================================================================
 * Functions
 *==========================================================================
 *
 * Load any files with function declarations.
 *
 */
array_map(function ($path) use ($root) {
    require "{$root}/src/{$path}.php";
}, ['Plugin/functions']);

/**
 *==========================================================================
 * Bootstrap
 *==========================================================================
 *
 * Load any additional boot scripts that should run before initiating the
 * launcher.
 *
 */
array_map(function ($path) use ($root) {
    require __DIR__ . "/{$path}.php";
}, ['constants',]);

/**
 *==========================================================================
 * Development
 *==========================================================================
 *
 * Load scripts to be used in development.
 *
 */
if (defined('LEONIDAS_DEVELOPMENT') && LEONIDAS_DEVELOPMENT) {

    // development bootstrapping
    if (file_exists($development = __DIR__ . '/development')) {
        array_map(function ($path) use ($development, $root) {
            require "{$development}/{$path}.php";
        }, ['loaded']);
    }

    // plugin playground
    if (file_exists($playground = "{$root}/.playground/plugin.php")) {
        require $playground;
    }
}
