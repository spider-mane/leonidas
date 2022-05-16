<?php

namespace Leonidas\Contracts\Admin\Component\Page;

interface BaseMenuPageInterface extends BaseAdminPageInterface
{
    public function getMenuTitle(): string;

    public function getPosition(): int;
}
