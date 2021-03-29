<?php

defined('ABSPATH') || exit;

$root = dirname(__DIR__, 1);

/**
 * The Composer vendor directory, definable by user so that a Composer-based
 * WordPress installation can have all plugin dependencies rerouted to the same
 * vendor directory as the installation
 */
if (!defined('COLTRANE_COMPOSER_DIR')) {
    define('COLTRANE_COMPOSER_DIR', $root . '/vendor');
}

if (!defined('COLTRANE_COMPOSER_JSON')) {
    define('COLTRANE_COMPOSER_JSON', $root . '/composer.json');
}
