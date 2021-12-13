<?php

use Dotenv\Dotenv;
use Env\Env;
use WebTheory\Debug\DebugHelper;
use WebTheory\GuctilityBelt\Config;

$root = dirname(__DIR__, 2);

require_once "$root/vendor/autoload.php";

/**
 * Capture environment variables from .env file
 */
Dotenv::createUnsafeImmutable($root)->load();

/**
 * Establish that plugin is in a development environment via constant
 */
define('LEONIDAS_DEVELOPMENT', true);

/**
 * Define global development variables
 */
$debug = Env::get('DEBUG_ENABLE');
$config = new Config("$root/config/development");
$errorLog = realpath($root . '/' . $config->get('debug.error_log.file'));
$editor = $config->get('debug.file_link.editor');
$linkFormat = $config->get("debug.file_link.formats.{$editor}")
    ?: ini_get('xdebug.file_link_format')
    ?: get_cfg_var('xdebug.file_link_format');

/**
 * Define debug settings
 */
DebugHelper::init([

    'ini' => [
        'error_reporting' => E_ALL,
        'display_errors' => true,
        'log_errors' => true,
        'error_log' => $errorLog,
    ],

    'xdebug' => [
        'cli_color' => 1,
        'file_link_format' => $linkFormat,
        'var_display_max_children' => 256,
        'var_display_max_data' => 1024,
        'var_display_max_depth' => 10,
    ],

    'error_logger' => [
        'channel' => $config->get('debug.error_log.channel')
    ],

    'error_handler' => [
        'link_format' => $linkFormat,
        'host_os' => $config->get('debug.system.host_os'),
        'host_path' => $config->get('debug.system.host_path'),
        'guest_path' => $config->get('debug.system.guest_path'),
    ],

    'var_dumper' => [
        'root' => $root,
        'theme' => $config->get('debug.var_dump.theme'),
        'server_host' => $config->get('debug.var_dump.server_host'),
    ],

]);
