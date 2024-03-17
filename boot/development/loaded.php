<?php

use WebTheory\WpTest\Skyhooks\SkyHooks;

/**
 * @var string $root
 */

// init skyhooks
SkyHooks::init();

// create playground entrypoints
play('init', ['root' => $root]);

add_action('leonidas/loaded', fn ($extension) => play('loaded', [
    'root' => $root,
    'extension' => $extension,
]));
