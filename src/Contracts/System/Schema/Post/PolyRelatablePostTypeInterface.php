<?php

namespace Leonidas\Contracts\System\Schema\Post;

use WP_Post;

interface PolyRelatablePostTypeInterface
{
    public function getMappedPostType(): string;

    public function getShadowTaxonomy(): string;

    /**
     * @return array<string>
     */
    public function getRelatedPostTypes(): array;

    public function addRelatedPostType(string $postType): void;

    public function createShadowTerm(WP_Post $post): void;

    public function updateShadowTerm(WP_Post $post): void;

    public function deleteShadowTerm(WP_Post $post): void;

    public function shadowTermExists(WP_Post $post): bool;
}
