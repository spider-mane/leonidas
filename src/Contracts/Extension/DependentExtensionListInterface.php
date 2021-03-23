<?php

namespace Leonidas\Contracts\Extension;

interface DependentExtensionListInterface
{
    public function addDependency(WpExtensionInterface $dependency): DependentExtensionListInterface;

    /**
     * @return WpExtensionInterface[]
     */
    public function getDependencies(): array;
}
