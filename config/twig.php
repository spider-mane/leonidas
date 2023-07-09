<?php

use WebTheory\Config\Deferred\Reflection;

use function Leonidas\Plugin\abspath;

return [

    'root' => abspath(),

    'paths' => [

        'views',

    ],

    'options' => [

        'autoescape' => false,
        'cache' => abspath('/var/cache/views/twig'),
        'debug' => Reflection::get('app.dev'),

    ],

    'extensions' => [

        # leonidas
        Leonidas\Library\Core\View\Twig\AdminFunctionsExtension::class,
        Leonidas\Library\Core\View\Twig\PrettyDebugExtension::class,
        Leonidas\Library\Core\View\Twig\SkyHooksExtension::class,
        Leonidas\Library\Core\View\Twig\StringHelperExtension::class,

    ],
];
