<?php

namespace WebTheory\Leonidas\Admin\Contracts;

use Psr\Http\Message\ServerRequestInterface;

interface ScreenComponentInterface
{
    /**
     *
     */
    public function render(ServerRequestInterface $request): string;

    /**
     *
     */
    public function shouldBeRendered(ServerRequestInterface $request): bool;
}
