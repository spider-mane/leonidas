<?php

namespace Leonidas\Contracts\System\Model\Category;

use Leonidas\Contracts\System\Model\FungibleRepositoryInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;

interface CategoryRepositoryInterface extends FungibleRepositoryInterface
{
    public function select(int $id): ?CategoryInterface;

    public function selectSlug(string $slug): ?CategoryInterface;

    public function whereIds(int ...$ids): CategoryCollectionInterface;

    public function whereObjectId(int $id): CategoryCollectionInterface;

    public function wherePost(PostInterface $post): CategoryCollectionInterface;

    public function whereParent(CategoryInterface $parent): CategoryCollectionInterface;

    public function all(): CategoryCollectionInterface;

    public function insert(CategoryInterface $category): void;

    public function update(CategoryInterface $category): void;
}
