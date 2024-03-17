<?php

return [

    'scripts' => ['constants'],

    'classes' => [

        Leonidas\Framework\Bootstrap\BindContainerToFacades::class,
        Leonidas\Framework\Bootstrap\RegisterModelServices::class,

    ],

    'options' => [

        'facade' => Leonidas\Plugin\Access\_Facade::class,

    ],

];
