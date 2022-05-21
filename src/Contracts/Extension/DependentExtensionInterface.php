<?php

namespace Leonidas\Contracts\Extension;

interface DependentExtensionInterface extends WpExtensionInterface
{
    public function getDependencies(): ?array;
}
