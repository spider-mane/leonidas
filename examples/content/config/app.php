<?php

use Leonidas\Library\System\Configuration\Taxonomy\Option\MaintainMetaboxHierarchy;

use function Example\Content\plugin_header;

return [

    'name' => plugin_header('name'),

    'version' => plugin_header('version'),

    'description' => plugin_header('description'),

    'slug' => plugin_header('textdomain'),

    'namespace' => 'content',

    'prefix' => 'content',

    'dev' => true,

    'modules' => [

        // core
        Leonidas\Framework\Module\PostTypes::class,
        Leonidas\Framework\Module\Taxonomies::class,

        // example
        Example\Content\Modules\PageMetaboxes::class,
        Example\Content\Modules\PostMetaboxes::class,
        Example\Content\Modules\SectionMetaboxes::class,
        Example\Content\Modules\StatementMetaboxes::class,
    ],

    'providers' => [
        Leonidas\Framework\Provider\League\CsrfRepositoryServiceProvider::class,
        Leonidas\Framework\Provider\League\GuzzleServerRequestServiceProvider::class,
    ],

    'data_managers' => [],

    'option_handlers' => [
        'post_type' => [],

        'taxonomy' => [
            'maintain_mb_hierarchy' => MaintainMetaboxHierarchy::class,
        ],
    ],
];
