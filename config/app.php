<?php

use Leonidas\Library\Core\Config\ConfigReflector;

return [

    'modules' => [
        Leonidas\Plugin\Modules\ProvisionAdminAssets::class,
    ],

    'services' => [
        [
            'id' => Twig\Environment::class,
            'provider' => Leonidas\Framework\Providers\TwigProvider::class,
            'args' => ConfigReflector::get('twig'),
            'shared' => true,
            'tags' => ['twig', 'template']
        ],
        [
            'id' => Leonidas\Library\Admin\Loaders\AdminNoticeCollectionLoaderInterface::class,
            'provider' => Leonidas\Framework\Providers\AdminNoticeCollectionLoaderProvider::class,
            'args' => ConfigReflector::map([
                'prefix' => 'plugin.slug'
            ]),
            'shared' => true,
            'tags' => ['admin_notices']
        ]
    ],

    'providers' => [],

    'bootstrap' => [],
];
