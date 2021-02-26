<?php

namespace WebTheory\Leonidas\Admin\Contracts;

interface SubmenuFileResolverInterface
{
    /**
     *
     */
    public function resolveSubmenuFile(string $submenuFile, string $parentFile): string;
}
