<?php

use Backalley\WordPress\PostType;
use Backalley\WordPress\Taxonomy;

return [

    'post_type' => [
        'option_handlers' => [
            'sort_by_term' => PostType\Args\SortByTermPostTypeArg::class,
            'somewhat_relatable_to' => PostType\Args\SomewhatRelatableToPostTypeArg::class,
        ]
    ],

    'taxonomy' => [
        'option_handlers' => [
            'maintain_mb_hierarchy' => Taxonomy\OptionHandlers\MaintainMetaboxHierarchy::class,
            'sortable' => Taxonomy\Args\SortableTaxonomyArg::class,
            'structural' => Taxonomy\Args\StructuralTaxonomyArg::class,
        ]
    ]
];
