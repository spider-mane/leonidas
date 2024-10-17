<?php

namespace Leonidas\Contracts\System\Configuration;

interface ModelConfigurationInterface extends
    ModelInfoInterface,
    ModelCoreConfigInterface,
    ModelPublicConfigInterface,
    ModelRestConfigInterface,
    ModelAdminConfigInterface
{
    public function getName(): string;

    public function getExtra(): array;
}
