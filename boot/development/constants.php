<?php

use WebTheory\Config\Interfaces\ConfigInterface;

use function Env\env;

/**
 * @var string $root
 * @var ConfigInterface $config
 */

define('LEONIDAS_DEVELOPMENT', env('LEONIDAS_DEVELOPMENT') ?? true);

/**
 * Specify constants specific to WordPress below
 *
 * @link https://developer.wordpress.org/apis/wp-config-php/
 * @link https://wordpress.org/support/article/debugging-in-wordpress
 * @link https://github.com/spider-mane/wpdmc
 *
 */

# database
define('DB_NAME', env('DB_NAME'));
define('DB_USER', env('DB_USER'));
define('DB_PASSWORD', env('DB_PASSWORD'));
define('DB_HOST', env('DB_HOST'));
define('DB_CHARSET', env('DB_CHARSET') ?? 'utf8');
define('DB_COLLATE', env('DB_COLLATE') ?? '');

# url
define('WP_HOME', env('WP_HOME'));
define('WP_SITEURL', env('WP_SITEURL') ?? WP_HOME);

# debugging
define('WP_DEBUG_MODE_CHECKS', false);
define('WP_DEBUG', $config->get('debug.enable'));
define('WP_DEBUG_DISPLAY', $config->get('debug.display'));
define('WP_DEBUG_LOG', $config->get('debug.log'));
define('WP_DISABLE_FATAL_ERROR_HANDLER', true);
define('SCRIPT_DEBUG', true);
define('WP_CACHE', false);
define('SAVEQUERIES', true);

# updates
define('AUTOMATIC_UPDATER_DISABLED', true);
define('WP_AUTO_UPDATE_CORE', false);
define('DISALLOW_FILE_MODS', true);

# misc
define('WP_ALLOW_MULTISITE', false);
