<?php

namespace Leonidas\Contracts\Admin\Components;

interface BaseMenuPageInterface extends BaseAdminPageInterface
{
    public function getMenuTitle(): string;

    public function getPosition(): ?int;
}
