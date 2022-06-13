<?php

use WebTheory\Config\Deferred\Reflection;

return [

    'root' => dirname(__DIR__),

    'paths' => ['views'],

    'options' => [

        'debug' => Reflection::get('app.dev'),

        'autoescape' => false,
    ],

    'extensions' => [
        Leonidas\Library\Core\View\Twig\AdminFunctionsExtension::class,
        Leonidas\Library\Core\View\Twig\PrettyDebugExtension::class,
        Leonidas\Library\Core\View\Twig\SkyHooksExtension::class,
        Leonidas\Library\Core\View\Twig\StringHelperExtension::class,
    ],

    'functions' => [],

    'filters' => [],

    'globals' => [],
];
