<?php

namespace Leonidas\Contracts\System\Model\Category;

use Leonidas\Contracts\System\Model\ModelCollectionInterface;

interface CategoryCollectionInterface extends ModelCollectionInterface
{
    public function getById(int $id): ?CategoryInterface;

    public function getBySlug(string $slug): ?CategoryInterface;

    public function add(CategoryInterface $category): void;

    public function merge(CategoryCollectionInterface $categories): CategoryCollectionInterface;

    public function containsWithId(int $id): bool;

    public function containsWithSlug(string $slug): bool;

    public function extractIds(): array;

    public function extractNames(): array;

    public function extractSlugs(): array;

    public function removeWithId(int $id): CategoryCollectionInterface;

    public function removeWithSlug(string $slug): CategoryCollectionInterface;

    public function matches(CategoryCollectionInterface $tags): bool;
}
