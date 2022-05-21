<?php

namespace Leonidas\Contracts\Extension;

interface DependableExtensionInterface extends WpExtensionInterface
{
    public function getDependents(): DependentExtensionListInterface;
}
