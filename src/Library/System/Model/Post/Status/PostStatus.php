<?php

namespace Leonidas\Library\System\Model\Post\Status;

use Leonidas\Contracts\System\Model\Post\Status\PostStatusInterface;

class PostStatus implements PostStatusInterface
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
