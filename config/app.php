<?php

use function Leonidas\Plugin\plugin_header;

return [

    'name' => plugin_header('name'),

    'version' => plugin_header('version'),

    'description' => plugin_header('description'),

    'slug' => plugin_header('textdomain'),

    'namespace' => 'leonidas',

    'prefix' => 'leon',

    'dev' => constant('LEONIDAS_DEVELOPMENT') ?? false,

    'modules' => [

        Leonidas\Plugin\Module\AdminAssets::class,

    ],

    'providers' => [

        # Framework
        Leonidas\Framework\Provider\League\AdminNoticeRepositoryServiceProvider::class,
        Leonidas\Framework\Provider\League\AutoInvokerServiceProvider::class,
        Leonidas\Framework\Provider\League\GuzzleServerRequestServiceProvider::class,
        Leonidas\Framework\Provider\League\TransientsChannelServiceProvider::class,
        Leonidas\Framework\Provider\League\TwigViewServiceProvider::class,

        # Plugin

    ],

    'bootstrap' => [

        Leonidas\Framework\Bootstrap\BindContainerToFacades::class,
        Leonidas\Framework\Bootstrap\RegisterModelServices::class,

    ],

    'facade' => Leonidas\Library\Access\_Facade::class,
];
