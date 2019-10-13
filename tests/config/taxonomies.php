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

];
