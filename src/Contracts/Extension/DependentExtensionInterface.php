<?php

namespace Leonidas\Contracts\Extension;

interface DependentExtensionInterface extends WpExtensionInterface
{
    /**
     * @var null|array
     */
    public function getDependencies(): array;
}
