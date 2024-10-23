<?php

namespace Leonidas\Contracts\System\Configuration\PostType;

use Leonidas\Contracts\System\Configuration\ModelAdminConfigInterface;

interface PostTypeAdminConfigInterface extends ModelAdminConfigInterface
{
    public function getDisplayedInMenu(): null|bool|string;

    public function isAllowedInAdminBar(): ?bool;

    public function getMenuPosition(): ?int;

    public function getMenuIcon(): ?string;

    public function getSupports(): null|array|bool;

    public function getRegisterMetaBoxCb(): ?callable;

    public function getTemplate(): null|array;

    public function getTemplateLock(): null|false|string;
}
