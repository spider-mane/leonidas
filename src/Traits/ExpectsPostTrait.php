<?php

namespace WebTheory\Leonidas\Traits;

use Psr\Http\Message\ServerRequestInterface;

trait UsesPostTrait
{
    /**
     *
     */
    protected function getPost(ServerRequestInterface $request)
    {
        return $request->getAttribute('post');
    }
}
