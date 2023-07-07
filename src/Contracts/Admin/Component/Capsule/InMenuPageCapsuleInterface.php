<?php

namespace Leonidas\Contracts\Admin\Component\Capsule;

interface InMenuPageCapsuleInterface extends AdminPageCapsuleInterface
{
    public function name(): string;

    public function position(): int;
}
