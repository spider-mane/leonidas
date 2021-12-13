#!/usr/bin/env php
<?php

use Tests\Ext\WpInstaller;

error_reporting(E_ALL);

$composer = json_decode(file_get_contents(getcwd() . '/composer.json'), true);
$vendor = $composer['config']['vendor-dir'] ?? 'vendor';

require_once getcwd() . '/' . $vendor . '/' . 'autoload.php';

WpInstaller::installWordPress();
