<?php

namespace WebTheory\Leonidas\MetaBox\Contracts;

use Psr\Http\Message\ServerRequestInterface;

/**
 *
 */
interface MetaboxContentInterface
{
    /**
     *
     */
    public function render(ServerRequestInterface $request);
}
