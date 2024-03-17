<?php

use function WebTheory\Config\env;
use function WebTheory\Config\reflect;

return [

    # database
    'db_name' => env('DB_NAME'),
    'db_user' => env('DB_USER'),
    'db_password' => env('DB_PASSWORD'),
    'db_host' => env('DB_HOST'),
    'db_charset' => env('DB_CHARSET') ?? 'utf8',
    'db_collate' => env('DB_COLLATE') ?? '',

    # url
    'wp_home' => env('WP_HOME'),
    'wp_siteurl' => env('WP_SITEURL') ?? env('WP_HOME'),

    # debugging
    'wp_debug_mode_checks' => false,
    'wp_debug' => reflect('debug.enable'),
    'wp_debug_display' => reflect('debug.display'),
    'wp_debug_log' => reflect('debug.log'),
    'wp_disable_fatal_error_handler' => true,
    'script_debug' => true,
    'wp_cache' => false,
    'savequeries' => true,

    # updates
    'automatic_updater_disabled' => true,
    'wp_auto_update_core' => false,
    'disallow_file_mods' => true,

    # misc
    'wp_allow_multisite' => false,

];
