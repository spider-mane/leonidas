<?php

namespace Leonidas\Contracts\System\Model\Category;

use Leonidas\Contracts\System\Model\FungibleRepositoryInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Library\System\Model\Category\CategoryCollection;

interface CategoryRepositoryInterface extends FungibleRepositoryInterface
{
    public function select(int $id): ?CategoryInterface;

    public function selectBySlug(string $slug): ?CategoryInterface;

    public function whereObjectId(int $id): CategoryCollection;

    public function withPost(PostInterface $post): CategoryCollection;

    public function withParent(CategoryInterface $parent): CategoryCollection;

    public function all(): CategoryCollection;

    public function insert(CategoryInterface $category): void;

    public function update(CategoryInterface $category): void;
}
