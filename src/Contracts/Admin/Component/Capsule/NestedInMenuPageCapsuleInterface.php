<?php

namespace Leonidas\Contracts\Admin\Component\Capsule;

use Leonidas\Contracts\Admin\Component\Page\ParentFileResolverInterface;
use Leonidas\Contracts\Admin\Component\Page\SubmenuFileResolverInterface;

interface NestedInMenuPageCapsuleInterface extends InMenuPageCapsuleInterface
{
    public function menu(): string;

    public function menuResolver(): ?ParentFileResolverInterface;

    public function nameResolver(): ?SubmenuFileResolverInterface;
}
