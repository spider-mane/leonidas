<?php

defined('ABSPATH') || exit;

$root = dirname(__DIR__, 1);

array_map(function ($path) use ($root) {
    require "{$root}/app/{$path}.php";
}, ['functions']);
