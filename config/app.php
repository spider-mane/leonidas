<?php

use Leonidas\Plugin\Modules\LeonidasAssetLoaderModule;

return [

    'name' => 'Leonidas',

    'prefix' => 'leon',

    'description' => 'Leonidas is a framework for creating plugins and themes for WordPress. It makes WordPress extensions easy to develop and maintain by defining a clean module-based architecture and exposing an expansive and extendable library of WordPress core abstractions, admin UI components, and other utilities for performing common tasks.',

    'dependencies' => [],

    'type' => 'plugin',

    'assets' => '/assets/dist',

    'modules' => [
        LeonidasAssetLoaderModule::class
    ],

    'providers' => [],

    'bootstrap' => [],
];
