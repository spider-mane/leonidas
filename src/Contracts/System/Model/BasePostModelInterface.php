<?php

namespace Leonidas\Contracts\System\Model;

use Leonidas\Contracts\System\Model\PostType\PostTypeInterface;

interface BasePostModelInterface
{
    public function getId(): int;

    public function getName(): string;

    public function getTitle(): string;

    public function getPostType(): PostTypeInterface;
}
