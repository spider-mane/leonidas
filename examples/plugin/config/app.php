<?php

use Leonidas\Library\System\Configuration\Taxonomy\Option\MaintainMetaboxHierarchy;

use function Leonidas\Plugin\plugin_header;

return [

    'name' => plugin_header('name'),

    'version' => plugin_header('version'),

    'description' => plugin_header('description'),

    'slug' => plugin_header('textdomain'),

    'namespace' => 'plugin',

    'prefix' => 'exp',

    'dev' => true,

    'modules' => [
        //
    ],

    'providers' => [
        //
    ],

    'data_managers' => [],

    'option_handlers' => [
        'post_type' => [],

        'taxonomy' => [
            'maintain_mb_hierarchy' => MaintainMetaboxHierarchy::class,
        ],
    ],
];
