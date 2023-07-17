<?php

use WebTheory\WpTest\Skyhooks\SkyHooks;

/**
 * @var string $root
 */

// init skyhooks
SkyHooks::init();

// create playground entrypoint
play('loaded');
