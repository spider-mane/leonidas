<?php

namespace Leonidas\Contracts\System\Model\Tag;

use Leonidas\Contracts\System\Model\FungibleRepositoryInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;

interface TagRepositoryInterface extends FungibleRepositoryInterface
{
    public function select(int $id): TagInterface;

    public function selectBySlug(string $slug): TagInterface;

    public function withObjectId(int $id): TagCollectionInterface;

    public function withPost(PostInterface $post): TagCollectionInterface;

    public function all(): TagCollectionInterface;

    public function insert(TagInterface $tag): void;

    public function update(TagInterface $tag): void;
}
