<?php

use WebTheory\WpTest\SkyHooks;

SkyHooks::init();

add_action('leonidas_loaded', function () use ($root) {
    require_once $root . '/example/plugin.php';
});
