<?php

namespace Leonidas\Contracts\System\Configuration\Taxonomy;

use Leonidas\Contracts\System\Configuration\ModelAdminConfigInterface;

interface TaxonomyAdminConfigInterface extends ModelAdminConfigInterface
{
    public function canHaveAdminColumn(): ?bool;

    public function isAllowedInMenu(): ?bool;

    public function isAllowedInQuickEdit(): ?bool;

    public function getMetaBoxCb(): null|bool|callable;

    public function getMetaBoxSanitizeCb(): ?callable;
}
