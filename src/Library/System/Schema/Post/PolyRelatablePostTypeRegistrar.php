<?php

namespace Leonidas\Library\System\Schema\Post;

use Leonidas\Contracts\System\Configuration\Taxonomy\TaxonomyRegistrarInterface;
use Leonidas\Contracts\System\Schema\Post\PolyRelatablePostTypeInterface;
use Leonidas\Contracts\System\Schema\Post\PolyRelatablePostTypeRegistrarInterface;
use Leonidas\Contracts\System\Schema\Post\PolyRelatablePostTypeRepositoryInterface;
use Leonidas\Library\System\Configuration\Taxonomy\TaxonomyBuilder;

class PolyRelatablePostTypeRegistrar implements PolyRelatablePostTypeRegistrarInterface
{
    public function __construct(
        protected PolyRelatablePostTypeRepositoryInterface $repository,
        protected TaxonomyRegistrarInterface $taxonomies
    ) {
        //
    }

    public function register(PolyRelatablePostTypeInterface $relatable): void
    {
        $this->registerShadowTaxonomy($relatable);
        $this->addToRepository($relatable);
    }

    public function update(string $relatable, string $related): void
    {
        register_taxonomy_for_object_type(
            $this->repository->get($relatable)->getShadowTaxonomy(),
            $related
        );
    }

    protected function addToRepository(PolyRelatablePostTypeInterface $relatable): void
    {
        $this->repository->add($relatable);
    }

    protected function registerShadowTaxonomy(PolyRelatablePostTypeInterface $relatable): void
    {
        $postType = get_post_type_object($relatable->getMappedPostType());

        $shadow = TaxonomyBuilder::for($postType->name)
            ->objectTypes(...$relatable->getRelatedPostTypes())
            ->singular($postType->labels->singular_name)
            ->plural($postType->labels->name)
            ->capabilities([
                'manage_terms' => 'edit_posts',
                'edit_terms' => 'edit_posts',
                'delete_terms' => 'edit_posts',
                'assign_terms' => 'edit_posts',
            ])
            ->args([
                'hierarchical' => false,
                'public' => false,
                'publicly_queryable' => false,
                'meta_box_cb' => false,
                'rest_base' => '',
                'show_ui' => true,
                'show_admin_column' => true,
                'show_in_menu' => false,
                'show_in_nav_menus' => true,
                'show_in_rest' => true,
                'show_in_quick_edit' => false,
                'show_tagcloud' => true,
            ])
            ->get();

        $this->taxonomies->registerOne($shadow);
    }
}
