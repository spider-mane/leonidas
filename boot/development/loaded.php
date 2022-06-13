<?php

use WebTheory\WpTest\SkyHooks;

$root = dirname(__DIR__, 2);

SkyHooks::init();

add_action('leonidas/loaded', function () use ($root) {
    require_once $root . '/example/plugin/plugin.php';
});
