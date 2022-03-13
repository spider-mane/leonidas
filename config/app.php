<?php

$name = 'Leonidas';

return [

    'name' => $name,

    'version' => '0.15.0',

    'slug' => 'leonidas',

    'prefix' => 'leon',

    'type' => 'plugin',

    'description' => "{$name} is a framework that helps developers create plugins and themes by simplifying some of the more common and complex tasks.",

    'dev' => defined('LEONIDAS_DEVELOPMENT'),

    'modules' => [

        # Framework modules

        # Plugin modules
        Leonidas\Plugin\Modules\AdminAssets::class,

    ],

    'services' => [],

    'providers' => [

        # Framework providers
        Leonidas\Framework\Providers\League\AdminNoticeRepositoryServiceProvider::class,
        Leonidas\Framework\Providers\League\GuzzleServerRequestServiceProvider::class,
        Leonidas\Framework\Providers\League\TransientsChannelServiceProvider::class,
        Leonidas\Framework\Providers\League\TwigViewServiceProvider::class,

        # Plugin providers

    ],

    'bootstrap' => [],
];
