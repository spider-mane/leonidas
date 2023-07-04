<?php

namespace Leonidas\Contracts\Admin\Registrar;

use Leonidas\Contracts\Admin\Component\Page\SubmenuPageInterface;
use Psr\Http\Message\ServerRequestInterface;

interface SubmenuPageRegistrarInterface
{
    public function registerOne(SubmenuPageInterface $page, ServerRequestInterface $request);
}
