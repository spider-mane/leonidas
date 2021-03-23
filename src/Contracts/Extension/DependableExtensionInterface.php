<?php

namespace Leonidas\Contracts\Extension;

interface DependableExtensionInterface extends WpExtensionInterface
{
    /**
     * @var null|array
     */
    public function getDependents(): DependentExtensionListInterface;
}
