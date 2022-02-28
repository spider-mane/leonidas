<?php

namespace Leonidas\Contracts\Admin\Components;

interface MenuPageInterface extends BaseMenuPageInterface
{
    public function getIconUrl(): ?string;

    public function getTitleInSubmenu(): ?string;
}
