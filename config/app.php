<?php

use function Leonidas\Plugin\header;

return [

    'name' => header('name'),

    'version' => header('version'),

    'slug' => header('textdomain'),

    'prefix' => 'leon',

    'type' => 'plugin',

    'description' => header('description'),

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
