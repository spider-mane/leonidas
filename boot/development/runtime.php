<?php

use WebTheory\Config\Interfaces\ConfigInterface;

ob_start();

/** @var ConfigInterface $config */
$config = require_once __DIR__ . '/setup.php';

/**
 * WordPress debug settings
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress
 */
define('WP_DEBUG_MODE_CHECKS', false); // used by webtheory/wp-test
define('WP_DEBUG', $config->get('debug.enable'));
define('WP_DEBUG_DISPLAY', $config->get('debug.display'));
define('WP_DEBUG_LOG', $config->get('debug.log'));
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
