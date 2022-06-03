<?php

namespace Leonidas\Contracts\System\Schema\Comment;

use Leonidas\Contracts\System\Schema\EntityManagerInterface;

interface CommentEntityManagerInterface extends EntityManagerInterface
{
    public const DATE_FORMAT = 'Y-m-d H:i:s';

    public function whereUserIds(int ...$userIds): object;

    public function whereAuthorEmail(string $authorEmail): object;

    public function whereAuthorUrl(string $authorUrl): object;

    public function whereParentIds(int ...$parentId): object;

    public function whereApprovedOnPost(int $postId): object;

    public function wherePostAndStatus(int $postId, string $status): object;
}
