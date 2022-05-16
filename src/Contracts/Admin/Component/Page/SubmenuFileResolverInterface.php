<?php

namespace Leonidas\Contracts\Admin\Component\Page;

use Psr\Http\Message\ServerRequestInterface;

interface SubmenuFileResolverInterface
{
    public function resolveSubmenuFile(ServerRequestInterface $request): string;
}
