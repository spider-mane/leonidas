<?php

namespace WebTheory\Leonidas\Contracts\Admin;

interface ParentFileResolverInterface
{
    /**
     *
     */
    public function resolveParentFile(string $parentFile): string;
}