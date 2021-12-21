<?php

defined('ABSPATH') || exit;

$root = dirname(__DIR__, 1);

if (file_exists($composer = "$root/vendor/autoload.php")) {
    require_once $composer;
}

require __DIR__ . '/functions.php';
require __DIR__ . '/constants.php';
