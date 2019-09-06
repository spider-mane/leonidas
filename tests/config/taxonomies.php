<?php

return [

    /**
     *
     */
    'ba_delivery_platforms' => [

        'hierarchical' => false,
        'meta_box_cb' => false,
        'public' => true,
        'publicly_queryable' => true,
        'rest_base' => 'backalley-delivery-platforms',
        'show_admin_column' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_quick_edit' => false,
        'show_in_rest' => true,
        'show_tagcloud' => false,
        'show_ui' => true,
        'object_types' => 'ba_location',

        'description' => '',

        'labels' => [
            'name' => 'Delivery Platforms',
            'singular_name' => 'Delivery Platform'
        ],

        'rewrite' => [
            'slug' => 'delivery-platforms',
            'with_front' => true,
            'hierarchical' => false
        ],
    ],

    /**
     *
     */
    'ba_menu_category' => [

        'hierarchical' => true,
        'meta_box_cb' => null,
        'public' => true,
        'publicly_queryable' => true,
        'rest_base' => 'menu-category',
        'show_admin_column' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_quick_edit' => true,
        'show_in_rest' => true,
        'show_tagcloud' => true,
        'show_ui' => true,
        'object_types' => 'ba_menu_item',

        'description' => 'Use this to organize',

        'labels' => [
            'name' => 'Menu Categories',
            'singular_name' => 'Menu Category'
        ],

        'rewrite' => [
            'slug' => 'menu-categories',
            'with_front' => true,
            'hierarchical' => true
        ],

        'options' => [
            'maintain_mb_hierarchy' => true,

            'sortable' => [
                'post_types' => 'ba_menu_item',
                'submenu_page' => [
                    'capability' => 'manage_options',
                    'menu_title' => 'Menu Structure',
                    'page_title' => 'Arrange Menu Categories'
                ]
            ]
        ]
    ],

    /**
     *
     */
    'ba_protein' => [

        'hierarchical' => false,
        'meta_box_cb' => null,
        'public' => true,
        'publicly_queryable' => true,
        'rest_base' => 'menu-item-protein',
        'show_admin_column' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_quick_edit' => false,
        'show_in_rest' => true,
        'show_tagcloud' => true,
        'show_ui' => true,
        'object_types' => 'ba_menu_item',

        'description' => '',

        'labels' => [
            'name' => 'Proteins',
            'singular_name' => 'Protein'
        ],

        'rewrite' => [
            'slug' => 'proteins',
            'with_front' => true,
            'hierarchical' => false
        ],
    ],

    /**
     *
     */
    'ba_diet' => [

        'hierarchical' => false,
        'meta_box_cb' => false,
        'public' => true,
        'publicly_queryable' => true,
        'rest_base' => 'menu-item-diet',
        'show_admin_column' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_quick_edit' => false,
        'show_in_rest' => true,
        'show_tagcloud' => true,
        'show_ui' => true,
        'object_types' => 'ba_menu_item',

        'description' => '',

        'labels' => [
            'name' => 'Diets',
            'singular_name' => 'Diet'
        ],

        'rewrite' => [
            'slug' => 'special-diets',
            'with_front' => true,
            'hierarchical' => false
        ],
    ],

    /**
     *
     */
    'ba_special' => [

        'hierarchical' => false,
        'meta_box_cb' => false,
        'public' => true,
        'publicly_queryable' => true,
        'rest_base' => 'menu-item-special',
        'show_admin_column' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_quick_edit' => false,
        'show_in_rest' => true,
        'show_tagcloud' => true,
        'show_ui' => true,
        'object_types' => 'ba_menu_item',

        'description' => '',

        'labels' => [
            'name' => 'Specials',
            'singular_name' => 'Special'
        ],

        'rewrite' => [
            'slug' => 'specials',
            'with_front' => true,
            'hierarchical' => false
        ],
    ],

    /**
     *
     */
    'ba_spice_level' => [

        'hierarchical' => false,
        'meta_box_cb' => false,
        'public' => true,
        'publicly_queryable' => true,
        'rest_base' => 'menu-item-spice-level',
        'show_admin_column' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_quick_edit' => false,
        'show_in_rest' => true,
        'show_tagcloud' => true,
        'show_ui' => true,
        'object_types' => 'ba_menu_item',

        'description' => '',

        'labels' => [
            'name' => 'Spice Levels',
            'singular_name' => 'Spice Level'
        ],

        'rewrite' => [
            'slug' => 'spice-level',
            'with_front' => true,
            'hierarchical' => false
        ],
    ],

    /**
     *
     */
    'ba_base' => [

        'hierarchical' => false,
        'meta_box_cb' => false,
        'public' => true,
        'publicly_queryable' => true,
        'rest_base' => 'menu-item-base',
        'show_admin_column' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_quick_edit' => false,
        'show_in_rest' => true,
        'show_tagcloud' => true,
        'show_ui' => true,
        'object_types' => 'ba_menu_item',

        'description' => '',

        'labels' => [
            'name' => 'Bases',
            'singular_name' => 'Base'
        ],

        'rewrite' => [
            'slug' => 'bases',
            'with_front' => true,
            'hierarchical' => false
        ],
    ]
];
