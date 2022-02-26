<?php

namespace Leonidas\Contracts\Admin\Components;

use Psr\Http\Message\ServerRequestInterface;

interface BaseAdminPageInterface extends AdminComponentInterface
{
    public function getPageTitle(): string;

    public function getMenuSlug(): string;

    public function getCapability(): string;

    public function getLoadErrorPage(): LoadErrorPageInterface;

    public function defineAdminTitle(ServerRequestInterface $request): ?string;
}
