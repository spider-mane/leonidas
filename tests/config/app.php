<?php

use Backalley\Post2Post\SomewhatRelatableToPostTypeArg;
use Backalley\Post2Post\TermRelatedPostsManager;
use Backalley\SortableObjects\SortByTermPostTypeArg;
use Backalley\SortableObjects\SortableTaxonomyArg;
use Backalley\StructuredTaxonomy\StructuralTaxonomyArg;
use Backalley\Taxtrubute\TermBasedPostMeta;
use Backalley\Wordpress\Taxonomy\OptionHandlers\MaintainMetaboxHierarchy;

return [
    'data_managers' => [
        'term_based_post_meta' => TermBasedPostMeta::class,
        'term_related_posts' => TermRelatedPostsManager::class,
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
