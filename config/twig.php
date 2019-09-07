<?php

return [
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

    'filters' => [
        'subjectify_objects' => 'backalley_subjectify_wp_objects',
        'copy' => 'DeepCopy\\deep_copy',
        'sort_terms_hierarchicaly' => 'sort_terms_hierarchicaly',
    ]
];