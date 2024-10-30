<?php

use Faker\Factory;

$fake = Factory::create()->unique();

return [

    'statement' => [

        '@info' => [
            'plural' => 'Statements',
            'singular' => 'Statement',
            'description' => 'Individual sales copy statements',
        ],

        '@core' => [
            'hierarchical' => false,
            'capability_type' => 'post',
            'delete_with_user' => false,
            'can_export' => true,
            'public' => true,
            'taxonomies' => [],
        ],

        '@REST' => [
            'show_in_rest' => false,
        ],

        '@public' => [
            'publicly_queryable' => false,
            'exclude_from_search' => false,
            'query_var' => false,
            'has_archive' => false,
            'rewrite' => false,
        ],

        '@admin' => [
            'show_ui' => true,
            'show_in_admin_bar' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'menu_position' => 18,
            'menu_icon' => 'dashicons-format-aside',
            'supports' => ['title', 'thumbnail', 'revisions'],
        ],

    ],

    'section' => [

        '@info' => [
            'plural' => 'Sections',
            'singular' => 'Section',
            'description' => 'Organized copy groups',
        ],

        '@core' => [
            'hierarchical' => true,
            'capability_type' => 'post',
            'delete_with_user' => false,
            'can_export' => true,
            'public' => true,
            'taxonomies' => [],
        ],

        '@REST' => [
            'show_in_rest' => false,
        ],

        '@public' => [
            'publicly_queryable' => false,
            'exclude_from_search' => false,
            'query_var' => false,
            'has_archive' => false,
            'rewrite' => false,
        ],

        '@admin' => [
            'show_ui' => true,
            'show_in_admin_bar' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'menu_position' => 19,
            'menu_icon' => 'dashicons-excerpt-view',
            'supports' => ['title', 'thumbnail'],
        ],

    ],
];
