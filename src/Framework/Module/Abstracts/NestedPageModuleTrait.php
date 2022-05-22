<?php

namespace Leonidas\Framework\Module\Abstracts;

use Leonidas\Contracts\Admin\Component\Page\BaseNestedPageInterface;
use Psr\Http\Message\ServerRequestInterface;

trait NestedPageModuleTrait
{
    use AdminPageModuleTrait;

    protected function filterSubmenuFile(string $submenuFile, string $parentFile): string
    {
        if (!$this->isMatchingSubmenuFile($submenuFile)) {
            return $submenuFile;
        };

        $request = $this->getServerRequest()
            ->withAttribute('submenu_file', $submenuFile)
            ->withAttribute('parent_file', $parentFile);

        return $this->resolvedSubmenuFile($request);
    }

    protected function filterParentFile(string $parentFile): string
    {
        if (!$this->isMatchingParentFile($parentFile)) {
            return $parentFile;
        }

        $request = $this->getServerRequest()
            ->withAttribute('parent_file', $parentFile);

        return $this->resoledParentFile($request) ?? $parentFile;
    }

    protected function isMatchingSubmenuFile(string $submenuFile): bool
    {
        return $this->propertyIsSet('definition')
            && $this->getDefinition()->getMenuSlug() === $submenuFile;
    }

    protected function isMatchingParentFile(string $parentFile): bool
    {
        return $this->propertyIsSet('definition')
            && $this->getDefinition()->getParentSlug() === $parentFile;
    }

    protected function resolvedSubmenuFile(ServerRequestInterface $request): ?string
    {
        return $this->getDefinition()->defineSubmenuFile($request);
    }

    protected function resoledParentFile(ServerRequestInterface $request): ?string
    {
        return $this->getDefinition()->defineParentFile($request);
    }

    abstract protected function getDefinition(): BaseNestedPageInterface;
}
