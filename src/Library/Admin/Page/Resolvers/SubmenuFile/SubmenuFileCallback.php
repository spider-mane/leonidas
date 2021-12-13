<?php

namespace Leonidas\Library\Admin\Page\Resolvers\SubmenuFile;

use Leonidas\Contracts\Admin\SubmenuFileResolverInterface;

class SubmenuFileCallback implements SubmenuFileResolverInterface
{
    protected $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function resolveSubmenuFile(string $submenuFile, string $parentFile): string
    {
        return ($this->callback)($submenuFile, $parentFile);
    }
}
