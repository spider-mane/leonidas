<?php

namespace Leonidas\Library\System\Model\Post;

use Psr\Link\LinkInterface;

class PostGuid implements LinkInterface
{
    protected string $href;

    public function __construct(string $href)
    {
        $this->href = $href;
    }

    public function __toString()
    {
        return $this->href;
    }

    public function getHref(): string
    {
        return $this->href;
    }

    public function getRels(): array
    {
        return [];
    }

    public function getAttributes(): array
    {
        return [];
    }

    public function isTemplated()
    {
        return false;
    }
}
