<?php

namespace Leonidas\Contracts\System\Schema\Comment;

interface CommentEntityManagerInterface
{
    public const DATE_FORMAT = 'Y-m-d H:i:s';

    public function select(int $id): object;

    public function whereIds(int ...$ids): object;

    public function whereUserIds(int ...$userIds): object;

    public function whereAuthorEmail(string $authorEmail): object;

    public function whereAuthorUrl(string $authorUrl): object;

    public function whereParentIds(int ...$parentId): object;

    public function wherePostAndStatus(int $postId, string $status): object;

    public function all(): object;

    /**
     * @link https://developer.wordpress.org/reference/classes/WP_Comment_Query/__construct/
     */
    public function query(array $args): object;

    public function make(array $data): object;

    /**
     * @link https://developer.wordpress.org/reference/functions/wp_insert_comment/
     */
    public function insert(array $data): void;

    public function update(int $id, array $data): void;

    public function delete(int $id): void;

    public function commit(): void;
}
