<?php

namespace WebTheory\Leonidas\Admin\Contracts;

interface MenuPageInterface extends AdminPageInterface
{
    public function getIconUrl(): string;

    public function getTitleInSubmenu(): string;
}
