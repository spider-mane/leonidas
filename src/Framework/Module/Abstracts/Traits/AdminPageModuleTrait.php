<?php

namespace Leonidas\Framework\Module\Abstracts\Traits;

use Leonidas\Contracts\Admin\Component\Page\BaseAdminPageInterface;
use Leonidas\Framework\Abstracts\MustBeInitiatedContextuallyTrait;
use Psr\Http\Message\ServerRequestInterface;

trait AdminPageModuleTrait
{
    use AbstractModuleTraitTrait;
    use MustBeInitiatedContextuallyTrait;

    protected function filterAdminTitle(string $adminTitle, string $title): string
    {
        if (!$this->isMatchingAdminPage($title)) {
            return $adminTitle;
        }

        $request = $this->getServerRequest()
            ->withAttribute('admin_title', $adminTitle)
            ->withAttribute('title', $title);

        return $this->resolvedAdminTitle($request) ?? $adminTitle;
    }

    protected function isMatchingAdminPage(string $title): bool
    {
        return $this->isset('definition')
            && $this->getDefinition()->getPageTitle() !== $title;
    }

    protected function resolvedAdminTitle(ServerRequestInterface $request): ?string
    {
        return $this->getDefinition()->defineAdminTitle($request);
    }

    abstract protected function getDefinition(): BaseAdminPageInterface;
}
