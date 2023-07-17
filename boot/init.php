<?php

defined('ABSPATH') || exit;

$root = dirname(__DIR__, 1);

// Require autoloader if installed as composer package
if (file_exists($autoload = "{$root}/vendor/autoload.php")) {
    require_once $autoload;
}

// Load individual bootstrap scripts
$scripts = [
    'constants',
];

foreach ($scripts as $script) {
    require __DIR__ . "/{$script}.php";
}

// Load functions
array_map(fn ($path) => require "{$root}/src/{$path}.php", [
    'Plugin/functions',
    'Plugin/Helper/helpers',
]);

// Conditionally load development entrypoint
if (defined('LEONIDAS_DEVELOPMENT')) {
    require __DIR__ . '/development/loaded.php';
}
