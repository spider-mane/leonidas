<?php

namespace Leonidas\Contracts\Admin\Registrar;

use Leonidas\Contracts\Admin\Component\Page\FlexPageInterface;

interface FlexPageRegistrarInterface
{
    public function registerOne(FlexPageInterface $page);
}
