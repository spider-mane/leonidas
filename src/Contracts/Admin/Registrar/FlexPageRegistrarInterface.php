<?php

namespace Leonidas\Contracts\Admin\Registrar;

use Leonidas\Contracts\Admin\Component\Page\FlexPageInterface;
use Psr\Http\Message\ServerRequestInterface;

interface FlexPageRegistrarInterface
{
    public function registerOne(FlexPageInterface $page, ServerRequestInterface $request);
}
