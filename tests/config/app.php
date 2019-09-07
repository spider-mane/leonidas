<?php

use Backalley\Post2Post\SomewhatRelatableToPostTypeArg;
use Backalley\SortableObjects\SortByTermPostTypeArg;
use Backalley\SortableObjects\SortableTaxonomyArg;
use Backalley\StructuredTaxonomy\StructuralTaxonomyArg;
use Backalley\Wordpress\Taxonomy\OptionHandlers\MaintainMetaboxHierarchy;

return [

    'post_type' => [
        'option_handlers' => [
            'sort_by_term' => SortByTermPostTypeArg::class,
            'somewhat_relatable_to' => SomewhatRelatableToPostTypeArg::class,
        ]
    ],

    'taxonomy' => [
        'option_handlers' => [
            'maintain_mb_hierarchy' => MaintainMetaboxHierarchy::class,
            'sortable' => SortableTaxonomyArg::class,
            'structural' => StructuralTaxonomyArg::class,
        ]
    ],

    'option_handlers' => [
        'post_type' => [
            'sort_by_term' => SortByTermPostTypeArg::class,
            'somewhat_relatable_to' => SomewhatRelatableToPostTypeArg::class,
        ],

        'taxonomy' => [
            'maintain_mb_hierarchy' => MaintainMetaboxHierarchy::class,
            'sortable' => SortableTaxonomyArg::class,
            'structural' => StructuralTaxonomyArg::class,
        ],
    ]
];
