<?php

use function Leonidas\Plugin\Functions\Config\info;

return [

    'name' => info('name'),

    'version' => info('version'),

    'description' => info('description'),

    'slug' => info('textdomain'),

    'namespace' => 'leonidas',

    'prefix' => 'leon',

    'dev' => defined('LEONIDAS_DEVELOPMENT'),

    'modules' => [

        # Framework
        Leonidas\Framework\Module\AdminScreenNoticesHandler::class,

        # Plugin
        Leonidas\Plugin\Module\AdminAssets::class,

    ],

    'providers' => [

        Leonidas\Framework\Provider\League\AdminNoticeLoaderServiceProvider::class,
        Leonidas\Framework\Provider\League\AdminNoticeRepositoryServiceProvider::class,
        Leonidas\Framework\Provider\League\AdminPageCallbackProviderServiceProvider::class,
        Leonidas\Framework\Provider\League\AutoInvokerServiceProvider::class,
        Leonidas\Framework\Provider\League\DeferredOptionValueFactoryServiceProvider::class,
        Leonidas\Framework\Provider\League\FlexPageRegistrarServiceProvider::class,
        Leonidas\Framework\Provider\League\GuzzleServerRequestServiceProvider::class,
        Leonidas\Framework\Provider\League\InteriorPageRegistrarServiceProvider::class,
        Leonidas\Framework\Provider\League\MenuPageRegistrarServiceProvider::class,
        Leonidas\Framework\Provider\League\MetaboxRegistrarServiceProvider::class,
        Leonidas\Framework\Provider\League\OptionRepositoryServiceProvider::class,
        Leonidas\Framework\Provider\League\RelatablePostKeysServiceProvider::class,
        Leonidas\Framework\Provider\League\SettingRegistrarServiceProvider::class,
        Leonidas\Framework\Provider\League\SettingsFieldRegistrarServiceProvider::class,
        Leonidas\Framework\Provider\League\SettingsSectionRegistrarServiceProvider::class,
        Leonidas\Framework\Provider\League\SubmenuPageRegistrarServiceProvider::class,
        Leonidas\Framework\Provider\League\TransientsChannelServiceProvider::class,
        Leonidas\Framework\Provider\League\TwigViewServiceProvider::class,

    ],

];
