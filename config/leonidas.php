<?php

return [

    'twig' => [

        'options' => [
            'autoescape' => false,
        ],

        'locations' => ['../public/templates'],

        'functions' => [
            'do_meta_boxes' => 'do_meta_boxes',
            'do_settings_sections' => 'do_settings_sections',
            'settings_errors' => 'settings_errors',
            'settings_fields' => 'settings_fields',
            'submit_button' => 'submit_button'
        ],

        'filters' => []
    ]
];
