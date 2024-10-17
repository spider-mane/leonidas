<?php

namespace Leonidas\Contracts\System\Configuration;

interface ModelCoreConfigInterface
{
    public function isPublic(): ?bool;

    public function isHierarchical(): ?bool;

    public function getCapabilities(): ?array;
}
