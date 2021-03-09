<?php

namespace WebTheory\Leonidas\Contracts\Admin;

interface SubmenuFileResolverInterface
{
    /**
     *
     */
    public function resolveSubmenuFile(string $submenuFile, string $parentFile): string;
}
