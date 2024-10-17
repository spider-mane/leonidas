<?php

use Faker\Factory;

$fake = Factory::create()->unique();

return [

    "post_type_1" => [

        "description" => $fake->sentence(),

        "labels" => [
            "name" => 'Post Type 1',
        ],
    ],

    "post_type_2" => [

        "description" => $fake->sentence(),

        "labels" => [
            "name" => 'Post Type 1',
        ],

    ],

    "post_type_3" => [

        "description" => $fake->sentence(),

        "labels" => [
            "name" => 'Post Type 1',
        ],

    ],

    "post_type_4" => [

        "description" => $fake->sentence(),

        "labels" => [
            "name" => 'Post Type 1',
        ],

    ],

    "post_type_5" => [

        "description" => $fake->sentence(),

        "labels" => [
            "name" => 'Post Type 1',
        ],

    ],

];
