<?php

namespace Leonidas\Contracts\Admin\Registrar;

use Leonidas\Contracts\Admin\Component\Page\MenuPageInterface;

interface MenuPageRegistrarInterface
{
    public function registerOne(MenuPageInterface $page);
}
