<?php

namespace WebTheory\Leonidas\Admin\Contracts;

interface SubmenuPageInterface extends AdminPageInterface
{
    public function getParentSlug(): string;

    public function defineParentFile(string $parentFile): string;

    public function defineSubmenuFile(string $submenuFile, string $parentFile): string;
}
