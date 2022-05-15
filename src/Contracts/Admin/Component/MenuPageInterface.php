<?php

namespace Leonidas\Contracts\Admin\Component;

interface MenuPageInterface extends BaseMenuPageInterface
{
    public function getIconUrl(): ?string;

    public function getTitleInSubmenu(): ?string;
}
