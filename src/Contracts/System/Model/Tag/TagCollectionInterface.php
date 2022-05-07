<?php

namespace Leonidas\Contracts\System\Model\Tag;

use Leonidas\Contracts\System\Model\ModelCollectionInterface;

interface TagCollectionInterface extends ModelCollectionInterface
{
    public function getById(int $id): TagInterface;

    public function getBySlug(string $slug): TagInterface;

    public function add(TagInterface $tag): void;

    public function collect(TagInterface ...$tags): void;

    public function merge(TagCollectionInterface $tags): TagCollectionInterface;

    public function containsWithId(int $id): bool;

    public function containsWithSlug(string $slug): bool;

    public function extractIds(): array;

    public function extractNames(): array;

    public function extractSlugs(): array;

    public function removeWithId(int $id): TagCollectionInterface;

    public function removeWithSlug(string $slug): TagCollectionInterface;

    public function matches(TagCollectionInterface $tags): bool;
}
