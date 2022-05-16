<?php

namespace Leonidas\Contracts\Admin\Registrar;

use Leonidas\Contracts\Admin\Component\Page\SubmenuPageInterface;

interface SubmenuPageRegistrarInterface
{
    public function registerOne(SubmenuPageInterface $page);
}
