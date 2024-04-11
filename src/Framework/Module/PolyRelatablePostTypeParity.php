<?php

namespace Leonidas\Framework\Module;

use Leonidas\Contracts\System\Schema\Post\PolyRelatablePostTypeInterface;
use Leonidas\Contracts\System\Schema\Post\PolyRelatablePostTypeRepositoryInterface;
use Leonidas\Framework\Module\Abstracts\Module;
use Leonidas\Hooks\TargetsAddedTermRelationshipHook;
use Leonidas\Hooks\TargetsDeletePostHook;
use Leonidas\Hooks\TargetsRegisteredTaxonomyForObjectTypeHook;
use Leonidas\Hooks\TargetsSavePostHook;
use WP_Post;
use WP_Term;

class PolyRelatablePostTypeParity extends Module
{
    use TargetsSavePostHook;
    use TargetsDeletePostHook;
    use TargetsAddedTermRelationshipHook;
    use TargetsRegisteredTaxonomyForObjectTypeHook;

    protected PolyRelatablePostTypeRepositoryInterface $repository;

    public function hook(): void
    {
        $this->targetSavePostHook();
        $this->targetDeletePostHook();
        $this->targetAddedTermRelationshipHook();
        $this->targetRegisteredTaxonomyForObjectTypeHook();
    }

    protected function doSavePostAction(int $postId, WP_Post $post, bool $update): void
    {
        if ($this->isSafeSavePostContext($post, $update)) {
            $this->updateTermWithPost($post);
        }
    }

    protected function doDeletePostAction(int $postId, WP_Post $post): void
    {
        if ($this->repositoryShadows($post)) {
            $this->deleteTermWithPost($post);
        }
    }

    protected function doAddedTermRelationshipAction(int $objectId, int $ttId, string $taxonomy): void
    {
        if ($this->repositoryHasShadow($taxonomy)) {
            $this->updateTermOnEntry($ttId, $taxonomy);
        }
    }

    protected function doRegisteredTaxonomyForObjectTypeAction(string $taxonomy, string $objectType): void
    {
        if ($this->repositoryHasShadow($taxonomy)) {
            $this->appendPostType($taxonomy, $objectType);
        }
    }

    protected function getRepository(): PolyRelatablePostTypeRepositoryInterface
    {
        return $this->repository ??= $this->repository();
    }

    protected function getHandler(WP_Post $post): PolyRelatablePostTypeInterface
    {
        return $this->getRepository()->get($post->post_type);
    }

    protected function getHandlerByShadow(string $shadow): PolyRelatablePostTypeInterface
    {
        return $this->getRepository()->getByShadow($shadow);
    }

    protected function isSafeSavePostContext(WP_Post $post, bool $update): bool
    {
        return $update
            && !$this->isAutoSave()
            && $this->repositoryShadows($post);
    }

    protected function isAutoSave(): bool
    {
        return defined('DOING_AUTOSAVE') && DOING_AUTOSAVE;
    }

    protected function shadowTermIsUpdated(WP_Term $term, WP_Post $post): bool
    {
        return $term->name === $post->post_title;
    }

    protected function repositoryShadows(WP_Post $post): bool
    {
        return $this->getRepository()->has($post->post_type);
    }

    protected function repositoryHasShadow(string $shadowTaxonomy): bool
    {
        return $this->getRepository()->hasByShadow($shadowTaxonomy);
    }

    protected function updateTermWithPost(WP_Post $post): void
    {
        $handler = $this->getHandler($post);

        if ($handler->shadowTermExists($post)) {
            $handler->updateShadowTerm($post);
        } else {
            $handler->createShadowTerm($post);
        }
    }

    protected function deleteTermWithPost(WP_Post $post): void
    {
        $this->getHandler($post)->deleteShadowTerm($post);
    }

    protected function updateTermOnEntry(int $ttId, string $taxonomy): void
    {
        $term = get_term_by('term_taxonomy_id', $ttId, $taxonomy);
        $post = get_post((int) $term->slug);

        if (!$this->shadowTermIsUpdated($term, $post)) {
            $this->getHandler($post)->updateShadowTerm($post);
        }
    }

    protected function appendPostType(string $shadow, string $postType): void
    {
        $this->getHandlerByShadow($shadow)->addRelatedPostType($postType);
    }

    protected function repository(): PolyRelatablePostTypeRepositoryInterface
    {
        return $this->getService(
            PolyRelatablePostTypeRepositoryInterface::class
        );
    }
}
