<?php

namespace Leonidas\Contracts\Admin\Components;

use Psr\Http\Message\ServerRequestInterface;

interface BaseNestedPageInterface extends BaseAdminPageInterface
{
    public function getParentSlug(): string;

    public function defineParentFile(ServerRequestInterface $request): ?string;

    public function defineSubmenuFile(ServerRequestInterface $request): ?string;
}
