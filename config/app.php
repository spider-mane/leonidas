<?php

$name = 'Leonidas';

return [

    'name' => $name,

    'version' => '0.15.0',

    'slug' => 'leonidas',

    'prefix' => 'leon',

    'type' => 'plugin',

    'description' => "{$name} is a development framework for creating plugins and themes for WordPress. It makes WordPress extensions easy to develop and maintain by defining a simple module-based architecture and exposing an extensive library of WordPress core abstractions, admin UI components, and utilities for performing other common tasks.",

    'dev' => defined('LEONIDAS_DEVELOPMENT'),

    'modules' => [

        # Framework modules

        # Plugin modules
        Leonidas\Plugin\Modules\AdminAssets::class,

    ],

    'providers' => [

        Leonidas\Framework\Providers\League\AdminNoticeRepositoryServiceProvider::class,
        Leonidas\Framework\Providers\League\TransientsChannelServiceProvider::class,
        Leonidas\Framework\Providers\League\TwigViewServiceProvider::class,

    ],

    'services' => [],

    'bootstrap' => [],
];
