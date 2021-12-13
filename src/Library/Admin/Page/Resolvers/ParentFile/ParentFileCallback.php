<?php

namespace Leonidas\Library\Admin\Page\Resolvers\ParentFile;

use Leonidas\Contracts\Admin\ParentFileResolverInterface;

class ParentFileCallback implements ParentFileResolverInterface
{
    protected $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function resolveParentFile(string $parentFile): string
    {
        return ($this->callback)($parentFile);
    }
}
