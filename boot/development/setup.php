<?php

use Dotenv\Dotenv;
use function Env\env;
use WebTheory\Config\Config;

use WebTheory\Exterminate\Exterminator;

$root = dirname(__DIR__, 2);

require_once "$root/vendor/autoload.php";

/**
 * Capture environment variables from .env
 */
Dotenv::createUnsafeImmutable($root)->load();

/**
 * Get development configuration
 */
$config = new Config("$root/config/development");

/**
 * Establish that plugin is in a development environment
 */
define('LEONIDAS_DEVELOPMENT', env('LEONIDAS_DEVELOPMENT') ?? true);

/**
 * Initiate debug support
 */
Exterminator::debug($config->get('debug'));

/**
 * Return development configuration
 */
return $config;
