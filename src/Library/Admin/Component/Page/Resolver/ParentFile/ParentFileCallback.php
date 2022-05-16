<?php

namespace Leonidas\Library\Admin\Component\Page\Resolver\ParentFile;

use Leonidas\Contracts\Admin\Component\Page\ParentFileResolverInterface;
use Psr\Http\Message\ServerRequestInterface;

class ParentFileCallback implements ParentFileResolverInterface
{
    protected $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function resolveParentFile(ServerRequestInterface $request): string
    {
        return ($this->callback)($request);
    }
}
