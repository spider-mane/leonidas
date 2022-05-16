<?php

namespace Leonidas\Contracts\Admin\Registrar;

use Leonidas\Contracts\Admin\Component\Page\InteriorPageInterface;

interface InteriorPageRegistrarInterface
{
    public function registerOne(InteriorPageInterface $page);
}
