<?php

namespace Leonidas\Library\Admin\Vessel;

use Leonidas\Contracts\Admin\Component\Capsule\MenuPageCapsuleInterface;
use Leonidas\Contracts\Admin\Component\Page\LoadErrorPageInterface;
use Leonidas\Contracts\Admin\Component\Page\MenuPageInterface;
use Psr\Http\Message\ServerRequestInterface;

class MenuPageVessel implements MenuPageInterface
{
    public function __construct(protected MenuPageCapsuleInterface $capsule)
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

    public function getMenuSlug(): string
    {
        return $this->capsule->slug();
    }

    public function getPosition(): int
    {
        return $this->capsule->position();
    }

    public function getIconUrl(): ?string
    {
        return $this->capsule->icon();
    }

    public function getTitleInSubmenu(): ?string
    {
        return $this->capsule->secondaryName();
    }

    public function getCapability(): string
    {
        return $this->capsule->capability();
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
}
