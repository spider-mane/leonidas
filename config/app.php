<?php

use Leonidas\Plugin\Modules\LeonidasAssetLoaderModule;

return [

    'name' => 'Leonidas',

    'prefix' => 'leon',

    'slug' => 'leonidas',

    'type' => 'plugin',

    'description' => 'Leonidas is a framework for creating plugins and themes for WordPress. It makes WordPress extensions easy to develop and maintain by defining a simple module-based architecture and exposing an expansive, extendable library of WordPress core abstractions, admin UI components, and other utilities for performing common WordPress related tasks.',

    'dependencies' => [],

    'assets' => '/assets/dist',

    'modules' => [
        LeonidasAssetLoaderModule::class
    ],

    'providers' => [],

    'bootstrap' => [],
];
