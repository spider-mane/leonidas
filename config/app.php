<?php

use Leonidas\Plugin\Modules\LeonidasActivationModule;
use Leonidas\Plugin\Modules\LeonidasAssetLoaderModule;

return [

    'modules' => [
        LeonidasActivationModule::class,
        LeonidasAssetLoaderModule::class
    ],

    'providers' => [],

    'bootstrap' => [],
];
