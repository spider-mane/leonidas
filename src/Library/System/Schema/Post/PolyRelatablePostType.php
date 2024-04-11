<?php

namespace Leonidas\Library\System\Schema\Post;

use Leonidas\Contracts\System\Schema\Post\PolyRelatablePostTypeInterface;
use Leonidas\Contracts\System\Schema\Post\RelatablePostKeyInterface;
use WP_Post;
use WP_Taxonomy;
use WP_Term;

class PolyRelatablePostType implements PolyRelatablePostTypeInterface
{
    protected WP_Taxonomy $shadow;

    /**
     * @var array<string>
     */
    protected array $related;

    public function __construct(
        protected string $postType,
        protected RelatablePostKeyInterface $keys,
        string ...$related
    ) {
        $this->related = $related;
    }

    public function getMappedPostType(): string
    {
        return $this->postType;
    }

    public function getShadowTaxonomy(): string
    {
        return $this->keys->getPostTypeKey($this->getMappedPostType());
    }

    public function getRelatedPostTypes(): array
    {
        return $this->related;
    }

    public function addRelatedPostType(string $postType): void
    {
        $this->related[] = $postType;
    }

    public function createShadowTerm(WP_Post $post): void
    {
        $args = ['slug' => $this->getShadowTermSlug($post)];

        wp_insert_term(
            $this->getShadowTermName($post),
            $this->getShadowTaxonomy(),
            $args
        );
    }

    public function updateShadowTerm(WP_Post $post): void
    {
        $term = $this->getPostTerm($post);
        $args = ['name' => $this->getShadowTermName($post)];

        wp_update_term($term->term_id, $this->getShadowTaxonomy(), $args);
    }

    public function deleteShadowTerm(WP_Post $post): void
    {
        $term = $this->getPostTerm($post);

        wp_delete_term($term->term_id, $this->getShadowTaxonomy());
    }

    public function shadowTermExists(WP_Post $post): bool
    {
        return (bool) term_exists(
            $this->getShadowTermSlug($post),
            $this->getShadowTaxonomy()
        );
    }

    public function shadowTermIsUpdated(WP_Term $term): bool
    {
        $post = $this->getTermPost($term);

        return $term->name === $post->post_title;
    }

    protected function getShadowTermName(WP_Post $post): string
    {
        return $post->post_title;
    }

    protected function getShadowTermSlug(WP_Post $post): string
    {
        return (string) $post->ID;
    }

    protected function getShadowTermPostId(WP_Term $term): int
    {
        return (int) $term->slug;
    }

    protected function getTermPost(WP_Term $term): WP_Post
    {
        return get_post($this->getShadowTermPostId($term));
    }

    protected function getPostTerm(WP_Post $post): WP_Term
    {
        return get_term_by(
            'slug',
            $this->getShadowTermSlug($post),
            $this->getMappedPostType()
        );
    }
}
