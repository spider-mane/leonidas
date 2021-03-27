<?php

use Leonidas\Framework\ConfigReflector;

return [

    'modules' => [
        Leonidas\Plugin\Modules\RegisterAssets::class,
        Leonidas\Plugin\Modules\ManageComposerDependencies::class,
        Leonidas\Plugin\Modules\Setup::class,
    ],

    'services' => [
        [
            'id' => Twig\Environment::class,
            'provider' => Leonidas\Framework\Providers\TwigProvider::class,
            'args' => ConfigReflector::get('twig'),
            'alias' => 'twig',
            'shared' => true,
        ],
        [
            'id' => Leonidas\Library\Admin\Loaders\AdminNoticeCollectionLoaderInterface::class,
            'provider' => Leonidas\Framework\Providers\AdminNoticeCollectionLoaderProvider::class,
            'args' => ConfigReflector::map([
                'prefix' => 'plugin.prefix.extended'
            ]),
            'alias' => 'notice_loader',
            'shared' => true,
        ]
    ],

    'providers' => [],

    'bootstrap' => [],
];
