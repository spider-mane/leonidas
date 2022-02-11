<?php

use WebTheory\WpTest\SkyHooks;

SkyHooks::collect();

add_action('leonidas_loaded', function () use ($root) {
    require_once $root . '/example/plugin.php';
});
