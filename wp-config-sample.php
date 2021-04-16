<?php

/**
 * The base configuration for WordPress
 *
 * This is a modified version of the original wp-config. Anything
 * not needed for theme/plugin development has been removed to
 * reduce visual clutter.
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 */

/** Set up debug settings and features */
require __DIR__ . '/boot/development.php';

/** The name of the database for WordPress */
define('DB_NAME', 'database_name_here');

/** MySQL database username */
define('DB_USER', 'username_here');

/** MySQL database password */
define('DB_PASSWORD', 'password_here');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/** */
define('WP_SITEURL', 'http://leonidas.test');

/** */
define('WP_HOME', 'http://leonidas.test');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
