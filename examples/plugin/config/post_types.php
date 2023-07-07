<?php

return [

    // /**
    //  *
    //  */
    // 'post' => [

    //     "can_export" => true,
    //     "capability_type" => "post",
    //     "exclude_from_search" => false,
    //     "has_archive" => true,
    //     "hierarchical" => false,
    //     "menu_icon" => "dashicons-welcome-write-blog",
    //     "menu_position" => 9,
    //     "public" => true,
    //     "publicly_queryable" => true,
    //     "show_in_admin_bar" => true,
    //     "show_in_menu" => true,
    //     "show_in_nav_menus" => true,
    //     "show_in_rest" => true,
    //     "show_ui" => true,
    //     "supports" => ["title"],

    //     'description' => 'Site blog',

    //     'labels' => [
    //         'name' => 'Blog Posts',
    //         'singular_name' => 'Blog Post',
    //         'menu_name' => 'Blog',
    //     ]
    // ],

    "wts_test_cpt" => [

        "can_export" => true,
        "capability_type" => "post",
        "exclude_from_search" => false,
        "has_archive" => true,
        "hierarchical" => false,
        "menu_icon" => "dashicons-carrot",
        "menu_position" => 5,
        "public" => true,
        "publicly_queryable" => true,
        "show_in_admin_bar" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "show_in_rest" => true,
        "show_ui" => true,
        "supports" => ["title", "_price"],

        "description" => "Product information pages.",

        "labels" => [
            "name" => "Menu Items",
            "singular_name" => "Menu Item",
            "menu_name" => "Menu",
        ],

        "rewrite" => [
            "slug" => "menu",
            "with_front" => true,
            "pages" => false,
            "feeds" => true,
        ],
    ],

    "wts_test_cpt_2" => [

        "can_export" => true,
        "capability_type" => "post",
        "exclude_from_search" => false,
        "has_archive" => true,
        "hierarchical" => false,
        "menu_icon" => "dashicons-location-alt",
        "menu_position" => 5,
        "public" => true,
        "publicly_queryable" => true,
        "show_in_admin_bar" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "show_in_rest" => true,
        "show_ui" => true,
        "supports" => ["title", "thumbnail"],

        "labels" => [
            "name" => "Locations",
            "singular_name" => "Location",
        ],

        "rewrite" => [
            "slug" => "locations",
            "with_front" => true,
            "pages" => true,
            "feeds" => true,
        ],

    ],
];
