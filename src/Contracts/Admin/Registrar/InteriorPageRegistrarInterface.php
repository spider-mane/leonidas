<?php

namespace Leonidas\Contracts\Admin\Registrar;

use Leonidas\Contracts\Admin\Component\Page\InteriorPageInterface;
use Psr\Http\Message\ServerRequestInterface;

interface InteriorPageRegistrarInterface
{
    public function registerOne(InteriorPageInterface $page, ServerRequestInterface $request);
}
