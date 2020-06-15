<?php

namespace WebTheory\Leonidas\Traits;

use Psr\Http\Message\ServerRequestInterface;

trait ExpectsTermTrait
{
    /**
     *
     */
    protected function getTerm(ServerRequestInterface $request)
    {
        return $request->getAttribute('term');
    }
}
