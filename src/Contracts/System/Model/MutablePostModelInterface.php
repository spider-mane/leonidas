<?php

namespace Leonidas\Contracts\System\Model;

use Psr\Link\LinkInterface;

interface MutablePostModelInterface extends PostModelInterface
{
    public function setName(string $name): self;

    public function setTitle(string $title): self;

    public function setGuid(LinkInterface $guid): self;

    public function setMenuOrder(int $menuOrder): self;

    public function setPageTemplate(string $pageTemplate): self;
}
