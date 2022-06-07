<?php

use WebTheory\Config\Deferred\Reflection;

return [

    'root' => dirname(__DIR__),

    'paths' => ['views'],

    'options' => [

        'debug' => Reflection::get('app.dev'),

        'autoescape' => false,
    ],

    'functions' => [
        'do_meta_boxes' => 'do_meta_boxes',
        'do_settings_sections' => 'do_settings_sections',
        'settings_errors' => 'settings_errors',
        'settings_fields' => 'settings_fields',
        'submit_button' => 'submit_button',
    ],

    'filters' => [],

    'globals' => [],
];
