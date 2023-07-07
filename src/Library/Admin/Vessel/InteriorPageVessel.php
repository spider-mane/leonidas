<?php

namespace Leonidas\Library\Admin\Vessel;

use Leonidas\Contracts\Admin\Component\Capsule\InteriorPageCapsuleInterface;
use Leonidas\Contracts\Admin\Component\Page\InteriorPageInterface;
use Leonidas\Contracts\Admin\Component\Page\LoadErrorPageInterface;
use Psr\Http\Message\ServerRequestInterface;

class InteriorPageVessel implements InteriorPageInterface
{
    public function __construct(protected InteriorPageCapsuleInterface $capsule)
    {
        //
    }

    public function getPageTitle(): string
    {
        return $this->capsule->title();
    }

    public function getParentSlug(): string
    {
        return $this->capsule->menu();
    }

    public function getMenuSlug(): string
    {
        return $this->capsule->slug();
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

    public function defineParentFile(ServerRequestInterface $request): ?string
    {
        return $this->capsule->menuResolver()->resolveParentFile($request);
    }

    public function defineSubmenuFile(ServerRequestInterface $request): ?string
    {
        return $this->capsule->nameResolver()->resolveSubmenuFile($request);
    }
}
