<?php

namespace Leonidas\Contracts\System\Schema\Comment;

use WP_Comment_Query;

interface CommentEntityManagerInterface
{
    public function select(int $id): object;

    public function whereIds(int ...$ids): object;

    public function whereAuthorIds(int ...$authorIds): object;

    public function whereAuthorEmail(string $authorEmail): object;

    public function whereAuthorUrl(string $authorUrl): object;

    public function whereParentIds(int ...$parentId): object;

    public function all(): object;

    public function find(array $queryArgs): object;

    public function query(WP_Comment_Query $query): object;

    public function insert(array $data): void;

    public function update(int $id, array $data): void;

    public function delete(int $id): void;

    public function commit(): void;
}
