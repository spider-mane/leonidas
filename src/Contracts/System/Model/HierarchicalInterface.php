<?php

namespace Leonidas\Contracts\System\Model;

interface HierarchicalInterface extends EntityModelInterface
{
    public function getParent(): ?HierarchicalInterface;

    public function getParentId(): int;
}
