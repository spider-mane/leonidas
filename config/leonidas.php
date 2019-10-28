<?php

return [

    'twig' => [

        'options' => [
            'autoescape' => false,
        ],

        'locations' => ['../public/templates'],

        'functions' => [
            'submit_button' => 'submit_button',
            'settings_fields' => 'settings_fields',
            'do_settings_sections' => 'do_settings_sections',
            'settings_errors' => 'settings_errors',
        ],

        'filters' => []
    ]
];
