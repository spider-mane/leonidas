<?php

use WebTheory\WpTest\Skyhooks\SkyHooks;

$root = dirname(__DIR__, 2);

// init skyhooks
SkyHooks::init();

// load playground
if (file_exists($playground = "{$root}/@playground/loaded.php")) {
    require $playground;
}
