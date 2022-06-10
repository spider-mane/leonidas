<?php

use function Leonidas\Plugin\plugin_header;

return [

    'name' => plugin_header('name'),

    'version' => plugin_header('version'),

    'slug' => plugin_header('textdomain'),

    'prefix' => 'leon',

    'type' => 'plugin',

    'description' => plugin_header('description'),

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

        \Leonidas\Framework\Bootstrap\BindContainerToFacades::class,
        \Leonidas\Framework\Bootstrap\RegisterModelServices::class,

    ],

    'facade' => \Leonidas\Library\Core\Access\_Facade::class,
];
