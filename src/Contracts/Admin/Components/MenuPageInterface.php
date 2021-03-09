<?php

namespace WebTheory\Leonidas\Contracts\Admin\Components;

use WebTheory\Leonidas\Contracts\Admin\Components\AdminPageInterface;

interface MenuPageInterface extends AdminPageInterface
{
    public function getIconUrl(): string;

    public function getTitleInSubmenu(): string;
}
