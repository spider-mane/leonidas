<?php

defined('ABSPATH') || exit;

$root = dirname(__DIR__, 1);

/**
 * Composer autoloader
 */
if (file_exists($autoload = "{$root}/vendor/autoload.php")) {
    require_once $autoload;
}

/**
 * Scripts to load before initiating Launcher
 */
array_map(fn ($path) => require __DIR__ . '/' . $path . '.php', [
    'functions',
]);

/**
 * Dev scripts
 */
if (defined($dev = 'LEONIDAS_DEVELOPMENT') && constant($dev)) {
    require __DIR__ . '/development/loaded.php';
}
