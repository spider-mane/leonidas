<?php

namespace Leonidas\Contracts\System\Model\Page;

use Leonidas\Contracts\System\Model\SoftDeletingRepositoryInterface;
use WP_Query;

interface PageRepositoryInterface extends SoftDeletingRepositoryInterface
{
    public function select(int $id): ?PageInterface;

    public function whereIds(int ...$ids): PageCollectionInterface;

    public function selectByName(string $name): ?PageInterface;

    public function whereNames(string ...$names): PageCollectionInterface;

    public function whereParent(?PageInterface $parent): PageCollectionInterface;

    public function whereParentId(int $parentId): PageCollectionInterface;

    public function find(array $args): PageCollectionInterface;

    public function query(WP_Query $query): PageCollectionInterface;

    public function all(): PageCollectionInterface;

    public function insert(PageInterface $post): void;

    public function update(PageInterface $post): void;
}
