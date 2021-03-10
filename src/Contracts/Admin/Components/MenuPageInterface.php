<?php

namespace Leonidas\Contracts\Admin\Components;

interface MenuPageInterface extends AdminPageInterface
{
    public function getIconUrl(): string;

    public function getTitleInSubmenu(): string;
}
