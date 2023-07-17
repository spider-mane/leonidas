<?php

use function Env\env;

ob_start();

(fn () => require __DIR__ . '/setup.php')();

$table_prefix = env('DB_TABLE_PREFIX') ?? 'wp_';

require_once ABSPATH . 'wp-settings.php';
