<?php

namespace Leonidas\Contracts\System\Model;

interface HierarchicalInterface
{
    public function getParent(): ?HierarchicalInterface;

    public function getParentId(): int;
}
