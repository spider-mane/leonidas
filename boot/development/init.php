<?php

use Dotenv\Dotenv;
use WebTheory\Config\Config;
use WebTheory\Exterminate\Exterminator;

$root = dirname(__DIR__, 2);

require_once "$root/vendor/autoload.php";

// Get development configuration
$config = new Config("$root/config/development");

// Set environment variables from .env
Dotenv::createUnsafeImmutable($root)->load();

// Initiate debug support
Exterminator::debug($config->get('debug'));
