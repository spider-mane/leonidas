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

        # Framework

        # Plugin
        \Leonidas\Plugin\Module\AdminAssets::class,

    ],

    'services' => [],

    'providers' => [

        # Framework
        \Leonidas\Framework\Provider\League\AdminNoticeRepositoryServiceProvider::class,
        \Leonidas\Framework\Provider\League\AutoInvokerServiceProvider::class,
        \Leonidas\Framework\Provider\League\GuzzleServerRequestServiceProvider::class,
        \Leonidas\Framework\Provider\League\TransientsChannelServiceProvider::class,
        \Leonidas\Framework\Provider\League\TwigViewServiceProvider::class,

        # Plugin

    ],

    'bootstrap' => [

        # Framework
        \Leonidas\Framework\Bootstrap\RegisterModelServices::class,
    ],
];
