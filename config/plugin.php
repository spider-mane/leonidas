<?php

$name = 'Leonidas';

return [

    'name' => $name,

    'prefix' => [
        'short' => 'leon',
        'extended' => 'leonidas'
    ],

    'type' => 'plugin',

    'description' => "{$name} is a framework for creating plugins and themes for WordPress. It makes WordPress extensions easy to develop and maintain by defining a simple module-based architecture and exposing an extensive library of WordPress core abstractions, admin UI components, and utilities for performing other common tasks.",

    'textdomain' => 'leonidas',

    'dependencies' => [],

    'assets' => 'assets/dist/',

    'dev' => defined('LEONIDAS_DEVELOPMENT'),
];
