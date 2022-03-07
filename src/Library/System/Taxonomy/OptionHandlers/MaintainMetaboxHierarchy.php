<?php

namespace Leonidas\Library\System\Taxonomy\OptionHandlers;

use Closure;
use Leonidas\Contracts\System\Taxonomy\TaxonomyInterface;
use Leonidas\Contracts\System\Taxonomy\TaxonomyOptionHandlerInterface;

class MaintainMetaboxHierarchy implements TaxonomyOptionHandlerInterface
{
    protected $taxonomies;

    public function __construct()
    {
        $this->hook();
    }

    public function getDefaultOptionName(): string
    {
        return 'maintain_metabox_hierarchy';
    }

    public function handle(TaxonomyInterface $taxonomy, $value): void
    {
        $this->taxonomies[] = $taxonomy->getName();
    }

    protected function hook(): void
    {
        add_filter(
            'wp_terms_checklist_args',
            Closure::fromCallable([$this, 'filterWpTermsChecklistArgs']),
            HOOK_DEFAULT_PRIORITY,
            PHP_INT_MAX
        );
    }

    protected function filterWpTermsChecklistArgs($args, $postId)
    {
        if (!in_array($args['taxonomy'], $this->taxonomies)) {
            return $args;
        }

        $args['checked_ontop'] = false;

        return $args;
    }
}
