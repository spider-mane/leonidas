<?php

namespace Leonidas\Library\Admin\Component\Page\Resolver\SubmenuFile;

use Leonidas\Contracts\Admin\Component\Page\SubmenuFileResolverInterface;
use Psr\Http\Message\ServerRequestInterface;

class SubmenuFileCallback implements SubmenuFileResolverInterface
{
    protected $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function resolveSubmenuFile(ServerRequestInterface $request): string
    {
        return ($this->callback)($request);
    }
}
