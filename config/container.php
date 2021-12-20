<?php

use WebTheory\Config\Deferred\Reflection;

return [

    'selection' => 'league',

    'services' => [
        [
            'id' => Twig\Environment::class,
            'provider' => Leonidas\Framework\Providers\TwigProvider::class,
            'args' => Reflection::get('twig'),
            'shared' => true,
            'tags' => ['twig', 'template', 'view']
        ],
        [
            'id' => Leonidas\Library\Admin\Loaders\AdminNoticeCollectionLoaderInterface::class,
            'provider' => Leonidas\Framework\Providers\AdminNoticeCollectionLoaderProvider::class,
            'args' => Reflection::map([
                'prefix' => 'plugin.slug'
            ]),
            'shared' => true,
            'tags' => ['admin_notices']
        ]
    ],

    'providers' => [],

    'configurations' => [

        'laminas' => [],

        'league' => [],

        'nette' => [],

        'php-di' => [],

        'pimple' => [],

        'symfony' => [],

        'yii' => [],
    ],
];
