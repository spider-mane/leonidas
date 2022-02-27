<?php

namespace Leonidas\Contracts\Admin;

use Psr\Http\Message\ServerRequestInterface;

interface AdminTitleResolverInterface
{
    public function resolveAdminTitle(ServerRequestInterface $request): string;
}
