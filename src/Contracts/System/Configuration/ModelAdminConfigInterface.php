<?php

namespace Leonidas\Contracts\System\Configuration;

interface ModelAdminConfigInterface
{
    public function isAllowedInUi(): ?bool;

    public function getLabels(): ?array;

    public function isAllowedInNavMenus(): null|bool;
}
