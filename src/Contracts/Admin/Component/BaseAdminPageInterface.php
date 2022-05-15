<?php

namespace Leonidas\Contracts\Admin\Component;

use Psr\Http\Message\ServerRequestInterface;

interface BaseAdminPageInterface extends AdminComponentInterface
{
    public function getPageTitle(): string;

    public function getMenuSlug(): string;

    public function getCapability(): string;

    public function getLoadErrorPage(): LoadErrorPageInterface;

    /**
     * @link https://developer.wordpress.org/reference/hooks/admin_title/
     */
    public function defineAdminTitle(ServerRequestInterface $request): ?string;
}
