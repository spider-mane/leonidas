<?php

namespace Leonidas\Contracts\Admin;

use Psr\Http\Message\ServerRequestInterface;

interface SubmenuFileResolverInterface
{
    public function resolveSubmenuFile(ServerRequestInterface $request): string;
}
