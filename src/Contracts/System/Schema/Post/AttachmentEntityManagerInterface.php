<?php

namespace Leonidas\Contracts\System\Schema\Post;

interface AttachmentEntityManagerInterface extends PostEntityManagerInterface
{
    public function whereAttachedToPost(int $id): object;
}
