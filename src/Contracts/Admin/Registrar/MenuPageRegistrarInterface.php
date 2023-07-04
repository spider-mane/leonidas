<?php

namespace Leonidas\Contracts\Admin\Registrar;

use Leonidas\Contracts\Admin\Component\Page\MenuPageInterface;
use Psr\Http\Message\ServerRequestInterface;

interface MenuPageRegistrarInterface
{
    public function registerOne(MenuPageInterface $page, ServerRequestInterface $request);
}
