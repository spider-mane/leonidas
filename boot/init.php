<?php

defined('ABSPATH') || exit;

$root = dirname(__DIR__, 1);

require __DIR__ . '/functions.php';
require __DIR__ . '/constants.php';

// require composer autoload if a site level composer.json has not been
// specified by the user
if (COLTRANE_COMPOSER_JSON === $root . '/composer.json') {
    require COLTRANE_COMPOSER_DIR . '/autoload.php';
}
