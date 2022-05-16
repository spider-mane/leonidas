<?php

namespace Leonidas\Contracts\Admin\Component\Page;

use Psr\Http\Message\ServerRequestInterface;

interface AdminTitleResolverInterface
{
    public function resolveAdminTitle(ServerRequestInterface $request): string;
}
