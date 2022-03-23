<?php

namespace Leonidas\Library\System\Model\Link;

use Psr\Link\LinkInterface;

class WebPage implements LinkInterface
{
    protected string $href;

    public function __construct(string $href)
    {
        $this->href = $href;
    }

    public function getHref(): string
    {
        return $this->href;
    }

    public function getRels(): array
    {
        return ['text/html'];
    }

    public function getAttributes()
    {
        return [];
    }

    public function isTemplated()
    {
        return false;
    }
}
