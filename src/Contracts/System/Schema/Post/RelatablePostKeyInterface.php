<?php

namespace Leonidas\Contracts\System\Schema\Post;

interface RelatablePostKeyInterface
{
    public function getPostKey(string $postType): string;
}
