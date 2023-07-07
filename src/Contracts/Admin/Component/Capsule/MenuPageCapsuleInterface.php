<?php

namespace Leonidas\Contracts\Admin\Component\Capsule;

interface MenuPageCapsuleInterface extends InMenuPageCapsuleInterface
{
    public function icon(): string;

    public function secondaryName(): ?string;
}
