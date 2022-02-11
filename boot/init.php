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
    wp_die(
        "Autoloader not found. Don't forget to run <code>composer install</code> shell command."
    );
}

require_once $autoload;


/**
 *==========================================================================
 * Functions
 *==========================================================================
 *
 * Load any files with function declarations
 *
 */
array_map(function ($path) use ($root) {
    require "{$root}/src/{$path}.php";
}, []);


/**
 *==========================================================================
 * Development boot scripts
 *==========================================================================
 *
 *
 *
 */
if (
    defined('LEONIDAS_DEVELOPMENT')
    && LEONIDAS_DEVELOPMENT
    && file_exists($development = __DIR__ . '/development')
) {
    array_map(function ($path) use ($development, $root) {
        require "{$development}/{$path}.php";
    }, ['loaded', 'playground',]);
}


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
