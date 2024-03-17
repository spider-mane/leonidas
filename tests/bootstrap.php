<?php

use Dotenv\Dotenv;
use WebTheory\Config\Config;
use WebTheory\Exterminate\Exterminator;

$root = dirname(__DIR__, 1);

require_once "$root/vendor/autoload.php";

// Get development configuration
$config = new Config("$root/config/development");

// Set environment variables from .env
Dotenv::createUnsafeImmutable($root)->load();

// Initiate debug support
Exterminator::debug($config->get('debug'));

// <?php

// $root = dirname(__DIR__);

// require_once "{$root}/boot/development/init.php";
