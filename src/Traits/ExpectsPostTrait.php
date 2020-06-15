<?php

namespace WebTheory\Leonidas\Traits;

use Psr\Http\Message\ServerRequestInterface;

trait ExpectsPostTrait
{
    /**
     *
     */
    protected function getPost(ServerRequestInterface $request)
    {
        return $request->getAttribute('post');
    }
}
