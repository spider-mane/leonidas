<?php

namespace Leonidas\Library\Admin\Vessel;

use Leonidas\Contracts\Admin\Component\Capsule\FlexPageCapsuleInterface;
use Leonidas\Contracts\Admin\Component\Page\FlexPageInterface;
use Leonidas\Contracts\Admin\Component\Page\LoadErrorPageInterface;
use Leonidas\Enum\Admin\Page\AdminPageContext;
use Psr\Http\Message\ServerRequestInterface;

class FlexPageVessel implements FlexPageInterface
{
    public function __construct(protected FlexPageCapsuleInterface $capsule)
    {
        //
    }

    public function getPageTitle(): string
    {
        return $this->capsule->title();
    }

    public function getMenuTitle(): string
    {
        return $this->capsule->name();
    }

    public function getParentSlug(): string
    {
        return $this->capsule->menu();
    }

    public function getMenuSlug(): string
    {
        return $this->capsule->slug();
    }

    public function getPosition(): int
    {
        return $this->capsule->position();
    }

    public function getCapability(): string
    {
        return $this->capsule->capability();
    }

    public function getContext(): AdminPageContext
    {
        return $this->capsule->context();
    }

    public function getIconUrl(): ?string
    {
        return $this->capsule->icon();
    }

    public function getTitleInSubmenu(): ?string
    {
        return $this->capsule->secondaryName();
    }

    public function shouldBeRendered(ServerRequestInterface $request): bool
    {
        return $this->capsule->policy()->approvesRequest($request);
    }

    public function renderComponent(ServerRequestInterface $request): string
    {
        return $this->capsule->layout()->renderComponent($request);
    }

    public function getLoadErrorPage(): LoadErrorPageInterface
    {
        return $this->capsule->error();
    }

    public function defineAdminTitle(ServerRequestInterface $request): ?string
    {
        return $this->capsule->titleResolver()->resolveAdminTitle($request);
    }

    public function defineParentFile(ServerRequestInterface $request): ?string
    {
        return $this->capsule->menuResolver()->resolveParentFile($request);
    }

    public function defineSubmenuFile(ServerRequestInterface $request): ?string
    {
        return $this->capsule->nameResolver()->resolveSubmenuFile($request);
    }
}
