<?php

namespace Leonidas\Contracts\System\Schema\Post;

interface RelatablePostKeyInterface
{
    public function getPostTypeKey(string $postType): string;

    public function getPostKey(string $postType): string;
}
