<?php

namespace Leonidas\Contracts\System\Model\Tag;

use Leonidas\Contracts\System\Model\FungibleRepositoryInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;

interface TagRepositoryInterface extends FungibleRepositoryInterface
{
    public function select(int $id): ?TagInterface;

    public function selectSlug(string $slug): ?TagInterface;

    public function whereIds(int ...$ids): TagCollectionInterface;

    public function whereObjectId(int $id): TagCollectionInterface;

    public function wherePost(PostInterface $post): TagCollectionInterface;

    public function all(): TagCollectionInterface;

    public function insert(TagInterface $tag): void;

    public function update(TagInterface $tag): void;
}
