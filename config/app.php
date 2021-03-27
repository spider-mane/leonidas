<?php

use Leonidas\Framework\ConfigReflector;

return [

    'root' => dirname(__FILE__, 1),

    'modules' => [
        Leonidas\Plugin\Modules\RegisterAssets::class,
        Leonidas\Plugin\Modules\ManageComposerDependencies::class,
        Leonidas\Plugin\Modules\Setup::class,
    ],

    'definitions' => [
        [
            'name' => Twig\Environment::class,
            'provider' => Leonidas\Framework\Providers\TwigProvider::class,
            'args' => ConfigReflector::key('twig'),
            'alias' => 'twig',
            'shared' => true,
        ],
        [
            'name' => Leonidas\Library\Admin\Loaders\AdminNoticeCollectionLoaderInterface::class,
            'provider' => Leonidas\Framework\Providers\AdminNoticeCollectionLoaderProvider::class,
            'args' => ConfigReflector::map([
                'prefix' => 'plugin.prefix.extended',
            ]),
            'alias' => 'notice_loader',
            'shared' => true,
        ]
    ],

    'providers' => [],

    'bootstrap' => [],
];
