<?php

namespace Leonidas\Contracts\Admin\Component;

use Psr\Http\Message\ServerRequestInterface;

interface BaseNestedPageInterface extends BaseAdminPageInterface
{
    public function getParentSlug(): string;

    /**
     * @link https://developer.wordpress.org/reference/hooks/parent_file/
     */
    public function defineParentFile(ServerRequestInterface $request): ?string;

    /**
     * @link https://developer.wordpress.org/reference/hooks/submenu_file/
     */
    public function defineSubmenuFile(ServerRequestInterface $request): ?string;
}
