<?php

namespace WebTheory\Leonidas\Contracts\Admin\Components;

interface AdminPageInterface extends AdminComponentInterface
{
    public function getPageTitle(): string;

    public function getMenuTitle(): string;

    public function getCapability(): string;

    public function getMenuSlug(): string;

    public function getPosition(): ?int;

    public function isShownInMenu(): bool;

    public function defineAdminTitle(string $adminTitle, string $title): string;
}
