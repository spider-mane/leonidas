<?php

namespace Leonidas\Contracts\System\Schema\Post;

interface AttachmentEntityManagerInterface extends PostEntityManagerInterface
{
    public function byAttachedToPost(int $id): ?object;

    public function whereAttachedToPost(int $id): object;
}
