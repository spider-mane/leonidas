<?php

use function Env\env;

ob_start();

require __DIR__ . '/setup.php';

$table_prefix = env('DB_TABLE_PREFIX') ?? 'wp_';
