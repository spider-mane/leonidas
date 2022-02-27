<?php

namespace Leonidas\Contracts\Admin;

use Psr\Http\Message\ServerRequestInterface;

interface ParentFileResolverInterface
{
    public function resolveParentFile(ServerRequestInterface $request): string;
}
