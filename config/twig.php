<?php

use function Leonidas\Plugin\Functions\Config\abspath;
use function WebTheory\Config\reflect;

return [

    'root' => abspath(),

    'paths' => [

        'views',

    ],

    'options' => [

        'autoescape' => false,
        'cache' => abspath('/var/cache/views/twig'),
        'debug' => reflect('app.dev'),

    ],

    'extensions' => [

        # leonidas
        Leonidas\Library\Core\View\Twig\AdminFunctionsExtension::class,
        Leonidas\Library\Core\View\Twig\PrettyDebugExtension::class,
        Leonidas\Library\Core\View\Twig\SkyHooksExtension::class,
        Leonidas\Library\Core\View\Twig\StringHelperExtension::class,

    ],
];
