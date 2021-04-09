<?php

$name = 'Leonidas';

return [

    'name' => $name,

    'version' => '0.11.0',

    'slug' => 'leonidas',

    'prefix' => 'leon',

    'type' => 'plugin',

    'description' => "{$name} is a development framework for creating plugins and themes for WordPress. It makes WordPress extensions easy to develop and maintain by defining a simple module-based architecture and exposing an extensive library of WordPress core abstractions, admin UI components, and utilities for performing other common tasks.",

    'assets' => 'assets/dist/',

    'dev' => defined('LEONIDAS_DEVELOPMENT'),
];
