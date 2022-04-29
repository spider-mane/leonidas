<?php

namespace Leonidas\Contracts\System\Model;

use Leonidas\Contracts\System\Model\PostType\PostTypeInterface;
use Psr\Link\LinkInterface;

interface PostModelInterface extends EntityModelInterface
{
    public function getName(): string;

    public function getTitle(): string;

    public function getGuid(): LinkInterface;

    public function getMenuOrder(): int;

    public function getPageTemplate(): string;

    public function getPostType(): PostTypeInterface;
}
