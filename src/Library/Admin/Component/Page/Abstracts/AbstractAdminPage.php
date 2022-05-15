<?php

namespace Leonidas\Library\Admin\Component\Page\Abstracts;

use Leonidas\Contracts\Admin\AdminTitleResolverInterface;
use Leonidas\Contracts\Admin\Component\AdminPageLayoutInterface;
use Leonidas\Contracts\Admin\Component\LoadErrorPageInterface;
use Leonidas\Library\Admin\Abstracts\CanBeRestrictedTrait;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractAdminPage
{
    use CanBeRestrictedTrait;

    protected string $pageTitle;

    protected string $menuSlug;

    protected string $capability = 'manage_options';

    protected AdminPageLayoutInterface $layout;

    protected ?AdminTitleResolverInterface $adminTitleResolver = null;

    protected LoadErrorPageInterface $loadErrorPage;

    public function __construct(
        string $pageTitle,
        string $menuSlug,
        AdminPageLayoutInterface $layout,
        LoadErrorPageInterface $loadErrorPage,
        ?string $capability = null,
        ?AdminTitleResolverInterface $adminTitleResolver = null
    ) {
        $this->pageTitle = $pageTitle;
        $this->menuSlug = $menuSlug;
        $this->layout = $layout;
        $this->loadErrorPage = $loadErrorPage;
        $this->adminTitleResolver = $adminTitleResolver;

        $capability && $this->capability = $capability;
    }

    public function getPageTitle(): string
    {
        return $this->pageTitle;
    }

    public function getMenuSlug(): string
    {
        return $this->menuSlug;
    }

    public function getCapability(): string
    {
        return $this->capability;
    }

    public function getLayout(): AdminPageLayoutInterface
    {
        return $this->layout;
    }

    public function getLoadErrorPage(): LoadErrorPageInterface
    {
        return $this->loadErrorPage;
    }

    public function getAdminTitleResolver(): ?AdminTitleResolverInterface
    {
        return $this->adminTitleResolver;
    }

    public function renderComponent(ServerRequestInterface $request): string
    {
        return $this->getLayout()->renderComponent($request);
    }

    public function defineAdminTitle(ServerRequestInterface $request): ?string
    {
        return ($resolver = $this->getAdminTitleResolver())
            ? $resolver->resolveAdminTitle($request)
            : null;
    }
}
