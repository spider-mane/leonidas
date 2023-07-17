<?php

use WebTheory\Config\Interfaces\ConfigInterface;

use function WebTheory\WpCliUtil\maybe_define_abspath;

// load dev boot scripts
foreach (['init', 'constants'] as $file) {
    require_once __DIR__ . "/{$file}.php";
}

/**
 * @var string $root
 * @var ConfigInterface $config
 */

maybe_define_abspath($root);

// create playground entrypoint
play('runtime');
