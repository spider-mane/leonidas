<?php

namespace WebTheory\Leonidas\Contracts\Extension;

interface ModuleInterface
{
    /**
     * @var WpExtensionInterface Extension base class that contains values to be used throughout all extension functions
     */
    public function __construct(WpExtensionInterface $extension);

    /**
     * @return void
     */
    public function hook(): void;
}
