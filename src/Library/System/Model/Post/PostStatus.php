<?php

namespace Library\System\Model\Post;

use Leonidas\Contracts\System\Model\Post\PostStatusInterface as PostPostStatusInterface;

class PostStatus implements PostPostStatusInterface
{
    protected string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
