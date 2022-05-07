<?php

namespace Leonidas\Library\Admin\Abstracts;

use Psr\Http\Message\ServerRequestInterface;

trait CannotBeRestrictedTrait
{
    public function shouldBeRendered(ServerRequestInterface $request): bool
    {
        return true;
    }
}
