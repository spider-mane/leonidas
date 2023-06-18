<?php

use WebTheory\WpTest\Skyhooks\SkyHooks;

$root = dirname(__DIR__, 2);

SkyHooks::init();

// load playground
if (file_exists($playground = "{$root}/@playground/loaded.php")) {
    require $playground;
}

// load examples
add_action('leonidas/loaded', function () use ($root) {
    require_once $root . '/example/plugin/plugin.php';
});
