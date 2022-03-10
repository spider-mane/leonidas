<?php

/**
 * The base configuration for WordPress
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 */

use function Env\env;
use function WebTheory\WpCliUtil\maybe_define_abspath;

call_user_func(function () {
    require_once __DIR__ . '/boot/development/runtime.php';
});

define('DB_NAME', env('DB_NAME'));
define('DB_USER', env('DB_USER'));
define('DB_PASSWORD', env('DB_PASSWORD'));
define('DB_HOST', env('DB_HOST'));
define('DB_CHARSET', env('DB_CHARSET') ?? 'utf8');
define('DB_COLLATE', env('DB_COLLATE') ?? '');

define('WP_HOME', env('WP_HOME'));
define('WP_SITEURL', env('WP_SITEURL') ?? WP_HOME);

define('WP_ALLOW_MULTISITE', false);

maybe_define_abspath(__DIR__);

$table_prefix = env('DB_TABLE_PREFIX') ?? 'wp_';

require_once ABSPATH . 'wp-settings.php';
