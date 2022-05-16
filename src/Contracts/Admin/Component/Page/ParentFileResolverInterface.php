<?php

namespace Leonidas\Contracts\Admin\Component\Page;

use Psr\Http\Message\ServerRequestInterface;

interface ParentFileResolverInterface
{
    public function resolveParentFile(ServerRequestInterface $request): string;
}
