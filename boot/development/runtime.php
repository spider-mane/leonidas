<?php

// ob_start();

require_once __DIR__ . '/setup.php';

/**
 * WordPress debug settings
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress
 */
define('WP_DEBUG_MODE_CHECKS', false); // used by webtheory/wp-dev
define('WP_DEBUG', true);
define('WP_DEBUG_DISPLAY', true);
define('WP_DEBUG_LOG', $errorLog);
define('WP_DISABLE_FATAL_ERROR_HANDLER', true);
define('SCRIPT_DEBUG', true);
define('WP_CACHE', false);
define('SAVEQUERIES', true);

/**
 * Other helpful settings for use in development
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 */
define('DISALLOW_FILE_MODS', true);
define('AUTOMATIC_UPDATER_DISABLED', true);
define('WP_AUTO_UPDATE_CORE', false);
