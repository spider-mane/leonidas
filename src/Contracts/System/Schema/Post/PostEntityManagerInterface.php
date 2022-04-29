<?php

namespace Leonidas\Contracts\System\Schema\Post;

use WP_Query;

interface PostEntityManagerInterface
{
    public const DATE_FORMAT = 'Y-m-d H:i:s';

    public function select(int $id): object;

    public function whereIds(int ...$ids): object;

    public function selectByName(string $name): object;

    public function whereNames(string ...$names): object;

    public function whereUser(int $user): object;

    public function whereUserAndStatus(int $user, string $status): object;

    public function whereParentId(int $parentId): object;

    public function whereStatus(string $status): object;

    public function all(): object;

    public function find(array $queryArgs): object;

    public function query(WP_Query $query): object;

    public function insert(array $data): void;

    public function update(int $id, array $data): void;

    public function delete(int $id): void;

    public function trash(int $id): void;

    public function recover(int $id): void;

    public function commit(): void;
}
