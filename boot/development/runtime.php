<?php

use WebTheory\Config\Interfaces\ConfigInterface;

$root = dirname(__DIR__, 2);

ob_start();

/** @var ConfigInterface $config */
$config = require_once __DIR__ . '/setup.php';

/**
 *==========================================================================
 * WordPress Debug Settings
 *==========================================================================
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress
 * @link https://github.com/spider-mane/wpdmc
 *
 */
define('WP_DEBUG_MODE_CHECKS', false);
define('WP_DEBUG', $config->get('debug.enable'));
define('WP_DEBUG_DISPLAY', $config->get('debug.display'));
define('WP_DEBUG_LOG', $config->get('debug.log'));
define('WP_DISABLE_FATAL_ERROR_HANDLER', true);
define('SCRIPT_DEBUG', true);
define('WP_CACHE', false);
define('SAVEQUERIES', true);

/**
 *==========================================================================
 * Disable Updates
 *==========================================================================
 *
 *
 *
 */
define('AUTOMATIC_UPDATER_DISABLED', true);
define('WP_AUTO_UPDATE_CORE', false);
define('DISALLOW_FILE_MODS', true);

/**
 *==========================================================================
 * Playground
 *==========================================================================
 *
 *
 *
 */
require_once dirname(__DIR__, 2) . '/.playground/boot.php';
