<?php

namespace WebTheory\Leonidas\Admin\Contracts;

interface ParentFileResolverInterface
{
    /**
     *
     */
    public function resolveParentFile(string $parentFile): string;
}
