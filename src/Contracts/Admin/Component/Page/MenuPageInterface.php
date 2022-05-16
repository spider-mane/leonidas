<?php

namespace Leonidas\Contracts\Admin\Component\Page;

interface MenuPageInterface extends BaseMenuPageInterface
{
    public function getIconUrl(): ?string;

    public function getTitleInSubmenu(): ?string;
}
